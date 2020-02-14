# UCF.R
# user coordinate fetcher
# get user coordinate from Google API and php and create a spatial point object
# ebrahim.jahanshiri@cffresearch.org
# ayman.salama@cffresearch.org
# rgdal without rgeos, in order to have rgeos package we need to install geos-devel on the server

# check package requirements

list.of.packages <- c("raster","rgdal", "maptools")
new.packages <- list.of.packages[!(list.of.packages %in% installed.packages()[,"Package"])]
if(length(new.packages)) install.packages(new.packages)
lapply(list.of.packages, require, character.only = TRUE)


# Reading coordinates from the selected point on map
args <- commandArgs(trailingOnly = TRUE)
print(args[1])
print(args[2])


# creating a log
#write(paste("usercoords at: ", date(), args[1], args[2]), append=T)

# Creating a spatial point object from the given coordinates
 coords = cbind(as.numeric(args[1]), as.numeric(args[2]))
  # coords = cbind(102.45386389999999, 3.2705262)
#sp = SpatialPoints(coords)
#data = 1
sp = SpatialPointsDataFrame(coords, data= as.data.frame(1))
crs(sp) = "+proj=longlat +datum=WGS84 +no_defs +ellps=WGS84 +towgs84=0,0,0"

# writing out the user coords points
# library(maptools)
#writePointsShape(sp, "usercoord")
#print(sp)

#source("./Rworshop/10_UCDF.R")
#rm (list = ls())

#---------------------------------------------------
#---------------------------------------------------

# UCDF.R
# User Climate data fetcher
# Extracts from climate, rasters based on the coordinate
# ebrahim.jahanshiri@cffresearch.org
# if you have problem with 'rgdal' package, you will need to uninstall and install the package again
# detach("package:rg", unload=TRUE)
# install.packages("rgdal", lib="/usr/lib64/R/library")




# get the raster of the area for temperature and rain fall
#require(raster)
raindata = stack()
tempdata = stack()
#tmindata = stack()
#zone = 29
for (i in 1:12) {
  temprast = raster(paste("/data/sci_data/worldClimData/tmean",i,"_global.tif",sep=""));  
#  tminrast = raster(paste("/data/sci_data/worldClimData/tmin",i,"_global.tif",sep="")); 
  rainrast = raster(paste("/data/sci_data/worldClimData/prec",i,"_global.tif",sep="")); 
  #temprast = mask(crop(temprast, extent(boundary)), boundary);
  #rainrast = mask(crop(rainrast, extent(boundary)), boundary);
  crs(temprast) = "+proj=longlat +datum=WGS84 +no_defs +ellps=WGS84 +towgs84=0,0,0";
#  crs(tminrast) = "+proj=longlat +datum=WGS84 +no_defs +ellps=WGS84 +towgs84=0,0,0";
  crs(rainrast) = "+proj=longlat +datum=WGS84 +no_defs +ellps=WGS84 +towgs84=0,0,0";
  #  assign (paste("tmean", i, district, country, sep=""), temprast) # in case of write out
  #  assign (paste("rain", i, district, country, sep=""), rainrast) # in case of write out
  raindata = addLayer(raindata, rainrast);
  tempdata = addLayer(tempdata, temprast);
#  tmindata = addLayer(tmindata, tminrast)
}
names(tempdata) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
#names(tmindata) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
names(raindata) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")


# user selected temperature and rainfall data
utemp <- data.frame(extract(tempdata, sp))
#utmin <- data.frame(extract(tmindata, sp))
urain <- data.frame(extract(raindata, sp))
print(utemp)
#print(utmin)
print(urain)
# write.table(utemp, "user_temp_monthly.txt")
# write.table(urain, "user_rain_monthly.txt")
# 
# rm (list = ls())


#---------------------------------------------------
#---------------------------------------------------
# PBUCSC.R
# Point based user climate suitability calculator
# calculates the total climte suitability (TCS) number based on the user selected location
# get user climate data monthly averages and perform a suitability analysis
# ebrahim.jahanshiri@cffresearch.org

# CHECK FOR EXISTANCE OF PACKAGES

utemp <- as.numeric(utemp)
#utmin <- as.numeric(utmin)
urain <- as.numeric(urain)

# GET THE CROP LIMITS 
ecology3 <- read.csv("Rworkshop/ecology3.csv")
# ecology3 <- read.csv("ecology3.csv")


# calculate the seasonal suitability for average seasonal temperature for n crops
 tecocrop = numeric()
 
for (i in 1:nrow(ecology3)){
  tmonsuit = numeric()  
    for (j in 1:12){
    # tempsuitfun = function(x) {
    #   y=0
    #   tabs_min=ecology3[i,"temperature_absolute_min"] 
    #   topt_min=ecology3[i,"temperature_optimal_min"] 
    #   topt_max=ecology3[i,"temperature_optimal_max"] 
    #   tabs_max=ecology3[i,"temperature_absolute_max"]
    #   if (any(x > tabs_min) & any(x < topt_min))  {y = round(((x - tabs_min)/(topt_min - tabs_min))*100)}
    #   if (any(x > topt_min) & any(x < topt_max)) {y  = 100}
    #   if (any(x > topt_max) & any(x < tabs_max))  {y  = round((1-( (x - topt_max)/(tabs_max - topt_max)))*100)}
    #   if (any(x < tabs_min) | any(x > tabs_max))  {y = 0}
    #   return(y)
    # }  
    x = utemp[j]/10
    #x = 27.1
 #   tempsuitfun = function(x) {
 #      y=0
      tabs_min=ecology3[i,"temperature_absolute_min"] 
      topt_min=ecology3[i,"temperature_optimal_min"] 
      topt_max=ecology3[i,"temperature_optimal_max"] 
      tabs_max=ecology3[i,"temperature_absolute_max"]
      if (x < tabs_min) {y = 0}
      if ((x >= tabs_min) & (x < topt_min)) {y = ((x - tabs_min)/(topt_min - tabs_min))}
      if ((x>= topt_min) & (x <topt_max))   {y=1}
      if ((x >= topt_max) & (x <tabs_max))   {y  = 1-( (x - topt_max)/(tabs_max - topt_max))} 
      if (x >= tabs_max) {y=0}

      
    
      
      #return(y)
 #   }  
    
    #tempcalc <- get(paste("tempaverage",i, sep=""))[j]/10 
    #tempcalc <-utemp[j]/10
    #tempcalc[is.na(tempcalc)] <- -9999 # to get rid of NA's
    
    #tempcalc <- lapply(tempcalc, tempsuitfun)
    
    tmonsuit= append(tmonsuit, as.numeric(y))  #CHAN test2
    #tempsuit = addLayer(tempsuit, tempcalc)
  }
  teco = cbind (tabs_min,topt_min,topt_max,tabs_max)
  tecocrop = rbind(tecocrop, teco)
  names(tmonsuit) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
  #assign(paste(ecology3[i,1],"_tempsuit", sep="") , tempsuit)
  assign(paste("tmonsuit",i, sep="") , tmonsuit)
}

# control the quality
tmonsuits=numeric()
for (i in 1:nrow(ecology3)){
  tmonsuits = rbind(tmonsuits,get(paste("tmonsuit",i,sep="")))
                }
# round(tmonsuits, digits =1)

# GETTING THE SEASONS RIGHT 
# average the temp for that crop to be used for temp suitability
tseason = numeric()
for (j in 1:nrow(ecology3)){
  season = round ((ecology3[j,"period_between_harvest_min"] + ecology3[j,"period_between_harvest_max"])/60)
  tseason = append(tseason, season)
  tcropsuit = numeric()
  tcropsuitpren = numeric()
  tmonsuit <- get(paste("tmonsuit",j, sep=""))
  
  # if (season == 0) {     #{stop("Season can not be 0")}
  #   # This is wrong but for the sake of now
  #   # to calcuate for the prennials all layers are the same
  #   for (i in 1:12){
  #     tempdataverage = append(tempdataverage, mean(utemp[1:12]))
  #   }
  # }
  if ((season < 12) & (season > 0)) {
    for (i in 1:(12-(season-1))){
      tcropsuit = append(tcropsuit, min(tmonsuit[i:(i+(season-1))]))
    }
    
    #creating a stack for the months that fall over dec
    tcropsuitpren = c(tmonsuit[(12-(season-2)):12], tmonsuit[1:(season-1)])
    
    # adding the aggreages for the rest of the year
    for (i in 1:(length(tcropsuitpren)-(season-1))){
      tcropsuit = append(tcropsuit, min(tcropsuitpren[i:(i+(season-1))]))
      }
    
    }
  
  if (season >= 12) {                           #CHAN test2
    # to calcuate for the prennials all layers are the same
    for (i in 1:12){
      tcropsuit = append(tcropsuit, min(tmonsuit))
    }
  }
  tcropsuit = tcropsuit[1:12]
  names(tcropsuit) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
  assign(paste("tcropsuit",j, sep="") , tcropsuit) 
}

# control the quality
tcropsuits=numeric()
for (i in 1:nrow(ecology3)){
  tcropsuits = rbind(tcropsuits,get(paste("tcropsuit",i,sep="")))
  #print(get(paste("tcropsuit",i,sep="")))
}
# round(tcropsuit, digits = 1)



# Aggregate the rain for each season starting from jan

# For a number of crops from 1 to n, get the season right 
# aggreate the rain for that crop to be use for rain suitability
rseason <- numeric()
for (j in 1:nrow(ecology3)){
  season = round ((ecology3[j,"period_between_harvest_min"] + ecology3[j,"period_between_harvest_max"])/60)
  rseason <- append(rseason, season)
  raindataggreg = numeric()
  raindatapren = numeric()
  # if (season == 0) {     #{stop("Season can not be 0")}
  #   # This is wrong but for the sake of now
  #   # to calcuate for the prennials all layers are the same
  #   for (i in 1:12){
  #     raindataggreg = append(raindataggreg, sum(urain))
  #   }
  # }
  if ((season < 12) & (season > 0)) {  #CHAN test2
    for (i in 1:(12-(season-1))){
      raindataggreg = append(raindataggreg, sum(urain[i:(i+(season-1))]))
    }
    
    #creating a stack for the months that fall over dec
    raindatapren = c(urain[(12-(season-2)):12], urain[1:(season-1)])
    
    # adding the aggreages for the rest of the year
    for (i in 1:(length(raindatapren)-(season-1))){
      raindataggreg = append(raindataggreg, sum(raindatapren[i:(i+(season-1))]))
    }
  }
  if (season >= 12) {          #CHAN test2
    # to calcuate for the prennials all layers are the same
    for (i in 1:12){
      raindataggreg = append(raindataggreg, sum(urain))
    }
  }
  raindataggreg = raindataggreg[1:12]
  names(raindataggreg) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
  assign(paste("rainaggreg",j, sep="") , raindataggreg) 
}

# control the quality
rainaggregs=numeric()
for (i in 1:nrow(ecology3)){
  rainaggregs = rbind(rainaggregs,get(paste("rainaggreg",i,sep="")))
  #print(get(paste("tcropsuit",i,sep="")))
}
#

# calcualte rain suitability
recocrop <- numeric()
for (i in 1:nrow(ecology3)){
  rainsuit = numeric()  
  for (j in 1:12){
    #rainsuitfun = function(x) {
      #y=0
   x <- get(paste("rainaggreg",i, sep=""))[j]
   
      rabs_min=ecology3[i,"rainfall_absolute_min"] 
      ropt_min=ecology3[i,"rainfall_optimal_min"] 
      ropt_max=ecology3[i,"rainfall_optimal_max"] 
      rabs_max=ecology3[i,"rainfall_absolute_max"]
      
      y=1
      if (x >= rabs_max) {y = 0}
      
      
      # if (any(x > rabs_min) & any(x < ropt_min))  {y = round(((x - rabs_min)/(ropt_min - rabs_min))*100)}
      # if (any(x > ropt_min) & any(x < ropt_max)) {y  = 100}
      # if (any(x > ropt_max) & any(x < rabs_max))  {y  = round((1-( (x - ropt_max)/(rabs_max - ropt_max)))*100)}
      # if (any(x < rabs_min) | any(x > rabs_max))  {y = 0}
     # return(y)
    #}  
    
    #raincalc <- get(paste("rainaggreg",i, sep=""))[j]
    #raincalc[is.na(raincalc)] <- -9999 # to get rid of NA's
    
    #raincalc <- lapply(raincalc, rainsuitfun )
    
    #raincalc = mask(crop(raincalc, extent(boundary)), boundary) #masking zeros 
    
    rainsuit= append(rainsuit, y)
    
  }
  reco = cbind (tabs_min,topt_min,topt_max,tabs_max)
  recocrop = rbind(tecocrop, reco)
  names(rainsuit) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
  assign(paste("rcropsuit",i, sep="") , rainsuit)
}

# control the quality
rainsuits=numeric()
for (i in 1:nrow(ecology3)){
  rainsuits = rbind(rainsuits,get(paste("rcropsuit",i,sep="")))
}

#round(rainsuit, digits=1)


# calculate total suitability 
for (j in 1:nrow(ecology3)){
  totalsuit = numeric()
  #raincalc <- calc(raindata, mean)
  temptotcal = as.numeric(get(paste("tcropsuit",j, sep="")))
  raintotcal = as.numeric(get(paste("rcropsuit",j, sep="")))
  
  for (i in 1:12){
    totalsuit=append(totalsuit,(temptotcal[i]* raintotcal[i])) 
  }
  #names(totalsuit) <- ecology3[1:nrow(ecology3),1]
  names(totalsuit) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
  assign(paste("totalsuit",j, sep="") , totalsuit) 
}

#control the quality
TCS=numeric()
for (i in 1:nrow(ecology3)){
  TCS = rbind(TCS,get(paste("totalsuit",i,sep=""))*100)
}
# cbind(CROP_ID = as.character(ecology3[,2]),TCS)
# write.csv(cbind(CROP_ID = ecology3[,2],TCS), "uTCSR.csv")
write.csv(cbind(CROP_ID = ecology3[,1],TCS), "")

#round(TCS, digits = 1)
#rm(list = ls())

#quality control variables:

# list <- list(coords, utemp, urain, tecocrop, tseason, tmonsuits, tcropsuits,
#              rseason, rainaggregs, recocrop, rainsuits, TCS)
# names(list) = c("coords", "utemp", "urain", "tecocrop", "tseason", "tmonsuits", "tcropsuits",
#                "rseason", "rainaggregs", "recocrop", "rainsuits", "TCS")
# # sink("quality_control.txt")
# print(list, digits =1)
# # sink()
