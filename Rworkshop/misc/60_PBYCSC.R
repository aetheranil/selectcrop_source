# PBUCSC.R
# Point based yield climate suitability calculator
# calculates the total climte suitability (TCS) number based on the user selected location
# get user climate data monthly averages and perform a suitability analysis
# ebrahim.jahanshiri@cffresearch.org

# CHECK FOR EXISTANCE OF PACKAGES
list.of.packages <- c("rgdal", "maptools", "raster")
new.packages <- list.of.packages[!(list.of.packages %in% installed.packages()[,"Package"])]
if(length(new.packages)) install.packages(new.packages)
lapply(list.of.packages, require, character.only = TRUE)


# GET THE CLIMATE DATA AT THE USER COORDINATE
ytemp <- read.table("yield_temp_monthly.txt")
yrain <- read.table("yield_rain_monthly.txt")

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


  write.csv(total.yield.based.cs, "yTCSR.csv")

  rm(list = ls())

