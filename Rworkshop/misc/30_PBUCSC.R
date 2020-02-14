# PBUCSC.R
# Point based user climate suitability calculator
# calculates the total climte suitability (TCS) number based on the user selected location
# get user climate data monthly averages and perform a suitability analysis
# ebrahim.jahanshiri@cffresearch.org

# CHECK FOR EXISTANCE OF PACKAGES
list.of.packages <- c("rgdal", "maptools", "raster")
new.packages <- list.of.packages[!(list.of.packages %in% installed.packages()[,"Package"])]
if(length(new.packages)) install.packages(new.packages)
lapply(list.of.packages, require, character.only = TRUE)

# GET THE CLIMATE DATA AT THE USER COORDINATE
utemp <- as.numeric(read.table("user_temp_monthly.txt"))
urain <- as.numeric(read.table("user_rain_monthly.txt"))

# GET THE CROP LIMITS 
ecology3 <- read.csv("ecology3.csv")

# GETTING THE SEASONS RIGHT 
# average the temp for that crop to be used for temp suitability
for (j in 1:nrow(ecology3)){
  season = round ((ecology3[j,"Ecocrop_Crop_Cycle_Min"] + ecology3[j,"Ecocrop_Crop_Cycle_Max"])/30)
  tempdataverage = numeric()
  tempdatapren = numeric()
  if (season == 0) {     #{stop("Season can not be 0")}
    # This is wrong but for the sake of now
    # to calcuate for the prennials all layers are the same
    for (i in 1:12){
      tempdataverage = append(tempdataverage, mean(utemp[1:12]))
    }
  }
  if ((season <= 12) & (season > 0)) {
    for (i in 1:(12-(season-1))){
      tempdataverage = append(tempdataverage, mean(utemp[i:(i+(season-1))]))
    }
    
    #creating a stack for the months that fall over dec
    tempdatapren = c(utemp[(12-(season-2)):12], utemp[1:(season-1)])
    
    # adding the aggreages for the rest of the year
    for (i in 1:(length(tempdatapren)-(season-1))){
      tempdataverage = append(tempdataverage, mean(tempdatapren[i:(i+(season-1))]))
    }
  }
  if (season > 12) {
    # to calcuate for the prennials all layers are the same
    for (i in 1:12){
      tempdataverage = append(tempdataverage, mean(utemp))
    }
  }
  names(tempdataverage) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
  assign(paste("tempaverage",j, sep="") , tempdataverage) 
}


# calculate the seasonal suitability for average seasonal temperature for n crops

for (i in 1:nrow(ecology3)){
  tempsuit = numeric()  
  for (j in 1:12){
    tempsuitfun = function(x) {
      y=0
      tabs_min=ecology3[i,"Agr_Ecol_Abs_Temp_Min"] 
      topt_min=ecology3[i,"Agr_Ecol_Opt_Temp_Min"] 
      topt_max=ecology3[i,"Agr_Ecol_Opt_Temp_Max"] 
      tabs_max=ecology3[i,"Agr_Ecol_Abs_Temp_Max"]
      if (any(x > tabs_min) & any(x < topt_min))  {y = round(((x - tabs_min)/(topt_min - tabs_min))*100)}
      if (any(x > topt_min) & any(x < topt_max)) {y  = 100}
      if (any(x > topt_max) & any(x < tabs_max))  {y  = round((1-( (x - topt_max)/(tabs_max - topt_max)))*100)}
      if (any(x < tabs_min) | any(x > tabs_max))  {y = 0}
      return(y)
    }  
    
    tempcalc <- get(paste("tempaverage",i, sep=""))[j]/10 
    #tempcalc[is.na(tempcalc)] <- -9999 # to get rid of NA's
    
    tempcalc <- lapply(tempcalc, tempsuitfun )
    
    tempsuit= append(tempsuit, tempcalc)
    #tempsuit = addLayer(tempsuit, tempcalc)
  }
  names(tempsuit) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
  #assign(paste(ecology3[i,1],"_tempsuit", sep="") , tempsuit)
  assign(paste("tempsuit",i, sep="") , tempsuit)
}

# control the quality
# text=numeric()
# for (i in 1:nrow(ecology3)){
#   text = rbind(text,get(paste("tempsuit",i,sep="")))
#                 }
# 

# Aggregate the rain for each season starting from jan

# For a number of crops from 1 to n, get the season right 
# aggreate the rain for that crop to be use for rain suitability
for (j in 1:nrow(ecology3)){
  season = round ((ecology3[j,"Ecocrop_Crop_Cycle_Min"] + ecology3[j,"Ecocrop_Crop_Cycle_Max"])/30)
  raindataggreg = numeric()
  raindatapren = numeric()
  if (season == 0) {     #{stop("Season can not be 0")}
    # This is wrong but for the sake of now
    # to calcuate for the prennials all layers are the same
    for (i in 1:12){
      raindataggreg = append(raindataggreg, sum(urain))
    }
  }
  if ((season <= 12) & (season > 0)) {
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
  if (season > 12) {
    # to calcuate for the prennials all layers are the same
    for (i in 1:12){
      raindataggreg = append(raindataggreg, sum(urain))
    }
  }
  names(raindataggreg) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
  assign(paste("rainaggreg",j, sep="") , raindataggreg) 
}
#    spplot(raindataggreg, main="Aggregate rainfal (for 6 month season starting each month) - Hulu Langat - Malaysia",
#       col.regions = rainbow(99, start=0.1))

#---

# calcualte rain suitability

for (i in 1:nrow(ecology3)){
  rainsuit = numeric()  
  for (j in 1:12){
    rainsuitfun = function(x) {
      y=0
      rabs_min=ecology3[i,"Agr_Ecol_Abst_Rain_Min"] 
      ropt_min=ecology3[i,"Agr_Ecol_Opt_Rain_Min"] 
      ropt_max=ecology3[i,"Agr_Ecol_Opt_Rain_Max"] 
      rabs_max=ecology3[i,"Agr_Ecol_Abst_Rain_Max"]
      if (any(x > rabs_min) & any(x < ropt_min))  {y = round(((x - rabs_min)/(ropt_min - rabs_min))*100)}
      if (any(x > ropt_min) & any(x < ropt_max)) {y  = 100}
      if (any(x > ropt_max) & any(x < rabs_max))  {y  = round((1-( (x - ropt_max)/(rabs_max - ropt_max)))*100)}
      if (any(x < rabs_min) | any(x > rabs_max))  {y = 0}
      return(y)
    }  
    
    raincalc <- get(paste("rainaggreg",i, sep=""))[j]
    #raincalc[is.na(raincalc)] <- -9999 # to get rid of NA's
    
    raincalc <- lapply(raincalc, rainsuitfun )
    
    #raincalc = mask(crop(raincalc, extent(boundary)), boundary) #masking zeros 
    
    rainsuit= append(rainsuit, raincalc)
    
  }
  names(rainsuit) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
  assign(paste("rainsuit",i, sep="") , rainsuit)
}

# control the quality
# text=numeric()
# for (i in 1:nrow(ecology3)){
#   text = rbind(text,get(paste("rainsuit",i,sep="")))
# }


# calculate total suitability 
for (j in 1:nrow(ecology3)){
  totalsuit = numeric()
  #raincalc <- calc(raindata, mean)
  temptotcal = as.numeric(get(paste("tempsuit",j, sep="")))
  raintotcal = as.numeric(get(paste("rainsuit",j, sep="")))
  
  for (i in 1:12){
    totalsuit=append(totalsuit,(0.01*(temptotcal[i]* raintotcal[i]))) 
  }
  #names(totalsuit) <- ecology3[1:nrow(ecology3),1]
  names(totalsuit) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
  assign(paste("totalsuit",j, sep="") , totalsuit) 
  }

#control the quality
TCS=numeric()
for (i in 1:nrow(ecology3)){
  TCS = rbind(TCS,get(paste("totalsuit",i,sep="")))
}

write.csv(cbind(CROP_ID = ecology3[,2],TCS), "uTCSR.csv")
#rm(list = ls())

