# YDF.R
# Reported Yield data fetcher
# Fetching reported yield data for n crops
# ebrahim.jahanshiri@cffresearch.org

# check package requirements

list.of.packages <- c("rgdal", "maptools","RgoogleMaps","raster")
new.packages <- list.of.packages[!(list.of.packages %in% installed.packages()[,"Package"])]
if(length(new.packages)) install.packages(new.packages)
lapply(list.of.packages, require, character.only = TRUE)



# GET THE YIELD DATA FOR ALL CROPS
yield <- read.csv("reportedyield.csv") ######coming from the DB to be replaced with Query

# GET THE YILED SUBSET DATA BASED ON THE TOP N CROPS
selid <- read.csv("selected_ids.csv") ###### coming from the php ...

# SUBSET DATA FOR SELECTED CROPS
sel.yield = yield[yield$Crop.ID %in% selid$Crop.ID,] 
#sel.yield = sel.yield [,c("Crop.ID", "reported_yield_mean..t.ha.")]

# WRITE THE DATA OUT
print(yield)
write.csv(yield, "yield_subset.csv")
#rm(list = ls())
#======= 50 



# GEOCODE THE ADDRESSES IF NEEDED
#library(RgoogleMaps)

# df <- data.frame(lat = numeric(), long = character(), stringsAsFactors = FALSE)
# 
# for (i in 1:nrow(yield)) {
#   df <-rbind(df, getGeoCode(yield$Location[i]))
#   Sys.sleep(3)
# }
# 
# yield <- data.frame(yield, df)

# CREATE AN SPATIAL OBJECT WITH YIELD SUBSTE
coordinates(yield) <- ~Long+Lat

# WRITE THE SPATIAL YIELD OBJECT ONTO DISK
writePointsShape(yield, "yieldsp")
print(yield)
#rm(list = ls())


#======================== 55 YCDF
# YCDF.R
# Yield Climate data fetcher
# Extracts from climate, rasters based on the subste yield coordinates
# ebrahim.jahanshiri@cffresearch.org
# if you have problem with 'rgdal' package, you will need to uninstall and install the package again
# detach("package:rg", unload=TRUE)
# install.packages("rgdal", lib="/usr/lib64/R/library")


# ASSUME THAT yieldsp OBJECT IS ALREADY LOADED or load it from file 
if (!exists("yieldsp")){yieldsp = readShapePoints("yieldsp.shp", 
                                                  CRS("+proj=longlat +datum=WGS84 +no_defs +ellps=WGS84 +towgs84=0,0,0"))} 

# get the raster of the area for temperature and rainfall
#require(raster)

if (!exists("tempdata") | !exists("raindata")){
  raindata = stack()
  tempdata = stack()
  #zone = 29
  for (i in 1:12) {
    temprast = raster(paste("/data/sci_data/worldClimData/tmean",i,"_global.tif",sep=""));  
    rainrast = raster(paste("/data/sci_data/worldClimData/prec",i,"_global.tif",sep="")); 
    #temprast = mask(crop(temprast, extent(boundary)), boundary);
    #rainrast = mask(crop(rainrast, extent(boundary)), boundary);
    crs(temprast) = "+proj=longlat +datum=WGS84 +no_defs +ellps=WGS84 +towgs84=0,0,0";
    crs(rainrast) = "+proj=longlat +datum=WGS84 +no_defs +ellps=WGS84 +towgs84=0,0,0";
    #  assign (paste("tmean", i, district, country, sep=""), temprast) # in case of write out
    #  assign (paste("rain", i, district, country, sep=""), rainrast) # in case of write out
    raindata = addLayer(raindata, rainrast)
    tempdata = addLayer(tempdata, temprast)
  }
  names(tempdata) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
  names(raindata) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
}

# user selected temperature and rainfall data  ,NAME = yieldsp$Name_Var_L
ytemp <- data.frame(CROP_ID = yieldsp$Crop_ID, 
                    NAME = yieldsp$Name_Var_L,
                    RYIELD.MEAN = yieldsp$repyieldme,
                    extract(tempdata, yieldsp))
yrain <- data.frame(CROP_ID = yieldsp$Crop_ID,
                    NAME = yieldsp$Name_Var_L,
                    RYIELD.MEAN = yieldsp$repyieldme,
                    extract(raindata, yieldsp))


#======================== 60

# PBUCSC.R
# Point based yield climate suitability calculator
# calculates the total climte suitability (TCS) number based on the user selected location
# get user climate data monthly averages and perform a suitability analysis
# ebrahim.jahanshiri@cffresearch.org




# REMOVE ROWS THAT CONTAIN NA, WRITING TO DISK
xytemp <- as.numeric(ytemp[complete.cases(ytemp),])
xyrain <- as.numeric(yrain[complete.cases(yrain),])

ytemp=xytemp
yrain=xyrain
# CHECKING ids
if (!all(ytemp$CROP_ID == yrain$CROP_ID)){
  stop("Crop IDs are not the same")
}

# GET THE CROP LIMITS SUPPLIED BY EDF.R
ecology3 <- read.csv("ecology3.csv") 

# SUBSET CROP LIMITS FOR ONLY THOSE SELECTED CROPS in ytemp and yrain
ecology3 <- ecology3[ecology3$cropID %in% ytemp$CROP_ID,] 

# ysuit = data.frame()

# SUBSEETING THE TEMPERATURE AND RAIN BASED ON CROPS
for (o in c(levels(factor(ecology3$cropID)))){  #o = c(levels(factor(ecology3$cropID)))[1]
  
  crop.subset.temp = subset(ytemp, CROP_ID == o)
  crop.subset.rain = subset(yrain, CROP_ID == o)
  crop.idname <- crop.subset.temp[,1:3]
  # getting rid of the ids so the code from PBUCSC can work
  crop.subset.temp = crop.subset.temp[,4:15]
  crop.subset.rain = crop.subset.rain[,4:15]
  # getting the ecological limits for the selected crop
  ecolim = subset(ecology3, cropID == o)
  # how many seasons this crop has
  season = round ((ecolim[,"Ecocrop_Crop_Cycle_Min"] + ecolim[,"Ecocrop_Crop_Cycle_Max"])/30)
  
  
  # RUNNING THE AVERAGES PER SEASON
  crop.temp.season.averages.tempsuit <- data.frame()
  
  for (n in 1:nrow(crop.subset.temp)) {
    tempdataverage = numeric()
    tempdatapren = numeric()
    if (season == 0) {     #{stop("Season can not be 0")}
      # This is wrong but for the sake of now
      # to calcuate for the prennials all layers are the same
      for (i in 1:12){
        tempdataverage = append(tempdataverage, mean(as.numeric(crop.subset.temp[n,1:12])))
      }
    }
    if ((season <= 12) & (season > 0)) {
      for (i in 1:(12-(season-1))){
        tempdataverage = append(tempdataverage, mean(as.numeric(crop.subset.temp[n,i:(i+(season-1))])))
      }
      
      #creating a stack for the months that fall over dec
      tempdatapren = c(crop.subset.temp[n,(12-(season-2)):12], crop.subset.temp[n,1:(season-1)])
      
      # adding the aggreages for the rest of the year
      for (i in 1:(length(tempdatapren)-(season-1))){
        tempdataverage = append(tempdataverage, mean(tempdatapren[i:(i+(season-1))]))
      }
    }
    if (season > 12) {
      # to calcuate for the prennials all layers are the same
      for (i in 1:12){
        tempdataverage = append(tempdataverage, mean(as.numeric(crop.subset.temp[n,])))
      }
    }
    
    
    # CALCULATING TEMPERATURE SUITABILITY
    tempsuit = numeric()
    for (j in 1:12){
      tempsuitfun = function(x) {
        y=0
        tabs_min=ecolim[,"Agr_Ecol_Abs_Temp_Min"] 
        topt_min=ecolim[,"Agr_Ecol_Opt_Temp_Min"] 
        topt_max=ecolim[,"Agr_Ecol_Opt_Temp_Max"] 
        tabs_max=ecolim[,"Agr_Ecol_Abs_Temp_Max"]
        if (any(x > tabs_min) & any(x < topt_min))  {y = round(((x - tabs_min)/(topt_min - tabs_min))*100)}
        if (any(x > topt_min) & any(x < topt_max)) {y  = 100}
        if (any(x > topt_max) & any(x < tabs_max))  {y  = round((1-( (x - topt_max)/(tabs_max - topt_max)))*100)}
        if (any(x < tabs_min) | any(x > tabs_max))  {y = 0}
        return(y)
      }  
      
      tempcalc <- tempdataverage[j]/10 
      #tempcalc[is.na(tempcalc)] <- -9999 # to get rid of NA's
      
      tempcalc <- lapply(tempcalc, tempsuitfun )
      
      tempsuit= append(tempsuit, tempcalc)
      #tempsuit = addLayer(tempsuit, tempcalc)
      
    }
    
    crop.temp.season.averages.tempsuit <- 
      rbind(crop.temp.season.averages.tempsuit, tempsuit)
    
  }
  
  names(crop.temp.season.averages.tempsuit) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
  #assign(paste("tempaverage",j, sep="") , tempdataverage) 
  
  # RUNNING THE SUMS PER SEASON
  crop.rain.season.sum.rainsuit <- data.frame()
  
  for (n in 1:nrow(crop.subset.rain)) {
    raindataggreg = numeric()
    raindatapren = numeric()
    if (season == 0) {     #{stop("Season can not be 0")}
      # This is wrong but for the sake of now
      # to calcuate for the prennials all layers are the same
      for (i in 1:12){
        raindataggreg = append(raindataggreg, sum(as.numeric(crop.subset.rain[n,1:12])))
      }
    }
    if ((season <= 12) & (season > 0)) {
      for (i in 1:(12-(season-1))){
        raindataggreg = append(raindataggreg, sum(as.numeric(crop.subset.rain[n,i:(i+(season-1))])))
      }
      
      #creating a stack for the months that fall over dec
      raindatapren = c(crop.subset.rain[n,(12-(season-2)):12], crop.subset.rain[n,1:(season-1)])
      
      # adding the aggreages for the rest of the year
      for (i in 1:(length(raindatapren)-(season-1))){
        raindataggreg = append(raindataggreg, sum(raindatapren[i:(i+(season-1))]))
      }
    }
    if (season > 12) {
      # to calcuate for the prennials all layers are the same
      for (i in 1:12){
        raindataggreg = append(raindataggreg, sum(as.numeric(crop.subset.rain[n,])))
      }
    }
    
    
    # CALCULATING RAINFALL SUITABILITY
    rainsuit = numeric()  
    for (j in 1:12){
      rainsuitfun = function(x) {
        y=0
        rabs_min=ecolim[,"Agr_Ecol_Abst_Rain_Min"] 
        ropt_min=ecolim[,"Agr_Ecol_Opt_Rain_Min"] 
        ropt_max=ecolim[,"Agr_Ecol_Opt_Rain_Max"] 
        rabs_max=ecolim[,"Agr_Ecol_Abs_Rain_Max"]
        if (any(x > rabs_min) & any(x < ropt_min))  {y = round(((x - rabs_min)/(ropt_min - rabs_min))*100)}
        if (any(x > ropt_min) & any(x < ropt_max)) {y  = 100}
        if (any(x > ropt_max) & any(x < rabs_max))  {y  = round((1-( (x - ropt_max)/(rabs_max - ropt_max)))*100)}
        if (any(x < rabs_min) | any(x > rabs_max))  {y = 0}
        return(y)
      }  
      
      raincalc <- raindataggreg[j]
      
      raincalc <- lapply(raincalc, rainsuitfun )
      
      #raincalc = mask(crop(raincalc, extent(boundary)), boundary) #masking zeros 
      
      rainsuit= append(rainsuit, raincalc)
      
      
    }
    
    crop.rain.season.sum.rainsuit <- 
      rbind(crop.rain.season.sum.rainsuit, rainsuit)
    
  }
  
  names(crop.rain.season.sum.rainsuit) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
  #assign(paste("tempaverage",j, sep="") , raindataggreg) 
  
  # calculate total suitability
  
  crop.season.totalsuit <- data.frame()
  for (j in 1:nrow(crop.subset.temp)){
    totalsuit = numeric()
    
    for (i in 1:12){
      totalsuit=append(totalsuit,(0.01*(crop.temp.season.averages.tempsuit[j,i]* crop.rain.season.sum.rainsuit[j,i]))) 
    }
    #names(totalsuit) <- ecology3[1:nrow(ecology3),1]
    crop.season.totalsuit = rbind(crop.season.totalsuit, totalsuit)
  }
  
  names(crop.season.totalsuit) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
  
  assign(paste("totalsuit_",o , sep="") , cbind(crop.idname, crop.season.totalsuit)) 
  
}

# COMBINING ALL THE TOTALS TOGETHER TO GET ALL CS FOR ALL YIELDS
total.yield.based.cs <- data.frame()
for (k in c(levels(factor(ecology3$cropID)))){  
  total.yield.based.cs <- rbind(total.yield.based.cs, get(paste("totalsuit_",k , sep="")))
}


#write.csv(total.yield.based.cs, "yTCSR.csv")
print(total.yield.based.cs)

#rm(list = ls())

#============================ 70
# PBYE.R
# forms a regression model and finds coeficients and then calculates yield for the user selected points
# ebrahim.jahanshiri@cffresearch.org



# GET THE YIELD DATA WITH CROPID 
#yield <- read.csv("yield_subset.csv")
#total.yield.based.cs <- read.csv("yTCSR.csv", row.names = 1)
total.user.based.cs <- read.csv("uTCSR.csv", row.names = 1)


sel.yield = total.user.based.cs[total.user.based.cs$CROP_ID %in% total.yield.based.cs$CROP_ID,] 
# sel.yield = total.user.based.cs[total.yield.based.cs$CROP_ID %in% total.user.based.cs$CROP_ID,] 

# FOR THE TOP CROP IN THE TCS LIST, FETCH 3 YIELD DATA AND LOCATIONS

# FOR EACH LOCATION GET A CLIMATE SUITABILITY

coefs <- data.frame()
for (o in c(levels(factor(total.yield.based.cs$CROP_ID)))){  
  
  # o = c(levels(factor(total.yield.based.cs$CROP_ID)))[1]
  
  sub = subset(total.yield.based.cs, CROP_ID == o)
  
  submean <- rowMeans(sub[,4:15])
  yield = sub[,3]                
  lm <- lm(yield ~  submean -1)
  coefs <- rbind (coefs, cbind(CROP_ID = as.numeric(o), coef = coef(lm)[1]) , make.row.names =F)
  #, coef = coef(lm)[2])
}

# yield = mean of climae suitability at that location for all the months * regression coeficient
cal.yield <- data.frame()
for (i in 1: nrow(sel.yield)){
  if (all (coefs$CROP_ID == sel.yield$CROP_ID)){
    cal.yield [i,1] =  coefs$CROP_ID[i]
    cal.yield [i,2] =  mean(as.numeric(sel.yield[i,2:13])) * as.numeric(coefs[i,2])  
  }
}


colnames(cal.yield) <- c("CROP_ID", "Cal.yield")
write.csv(cal.yield, "cal_yield.csv", row.names = F)


#mean(total.yield.based.cs$RYIELD.MEAN)

#sel.yield[1,2:13] <- 100
#mean(as.numeric(sel.yield[1,2:13])) * as.numeric(coefs[1,2])



