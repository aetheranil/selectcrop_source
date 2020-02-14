# UCF.R
# user coordinate fetcher
# get user coordinate from Google API and php and create a spatial point object
# ebrahim.jahanshiri@cffresearch.org
# ayman.salama@cffresearch.org
# rgdal without rgeos, in order to have rgeos package we need to install geos-devel on the server

# check package requirements
# .libPaths( c( .libPaths(), "/home/cffrc/R/x86_64-redhat-linux-gnu-library/3.2") )
# .libPaths()
# install.packages("RMySQL")
list.of.packages <- c("raster","rgdal", "maptools","RMySQL")
new.packages <- list.of.packages[!(list.of.packages %in% installed.packages()[,"Package"])]
if(length(new.packages)) install.packages(new.packages)
lapply(list.of.packages, require, character.only = TRUE)

# Reading coordinates from the selected point on map
args <- commandArgs(trailingOnly = TRUE)
print(args[1])
print(args[2])

# Creating a spatial point object from the given coordinates
coords = cbind(as.numeric(args[1]), as.numeric(args[2]))
 coords = cbind(102.45386389999999, 3.2705262)
sp = SpatialPointsDataFrame(coords, data= as.data.frame(1))
crs(sp) = "+proj=longlat +datum=WGS84 +no_defs +ellps=WGS84 +towgs84=0,0,0"


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
raindata = stack()
tempdata = stack()
for (i in 1:12) {
  temprast = raster(paste("/data/sci_data/worldClimData/tmean",i,"_global.tif",sep=""));  
  rainrast = raster(paste("/data/sci_data/worldClimData/prec",i,"_global.tif",sep="")); 
  crs(temprast) = "+proj=longlat +datum=WGS84 +no_defs +ellps=WGS84 +towgs84=0,0,0";
  crs(rainrast) = "+proj=longlat +datum=WGS84 +no_defs +ellps=WGS84 +towgs84=0,0,0";
  raindata = addLayer(raindata, rainrast);
  tempdata = addLayer(tempdata, temprast);
}
names(tempdata) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")

names(raindata) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")


# user selected temperature and rainfall data
utemp <- data.frame(extract(tempdata, sp))
urain <- data.frame(extract(raindata, sp))
print(utemp)
print(urain)

#---------------------------------------------------
#---------------------------------------------------
# PBUCSC.R
# Point based user climate suitability calculator
# calculates the total climte suitability (TCS) number based on the user selected location
# get user climate data monthly averages and perform a suitability analysis
# ebrahim.jahanshiri@cffresearch.org

# CHECK FOR EXISTANCE OF PACKAGES

utemp <- as.numeric(utemp)
urain <- as.numeric(urain)

# GET THE CROP LIMITS 
# ecology3 <- read.csv("Rworkshop/ecology3.csv")
 # ecology3 <- read.csv("ecology3.csv")

 # library(RMySQL)
# library(RMySQL)


# Connecting to MySQL:
#   Once the RMySQL library is installed create a database connection object.

mydb = dbConnect(MySQL(), user='root', password='yuna2UtR', dbname='cropbase_v_4_2', host='127.0.0.1')

# Listing Tables and Fields:
#   Now that a connection has been made we list the tables and fields in the database we connected to.

# dbListTables(mydb)

# This will return a list of the tables in our connection. 

# dbListFields(mydb, 'agro_agroecology')

# This will return a list of the fields in some_table.

# Running Queries:
#   Queries can be run using the dbSendQuery function.

rs = dbSendQuery(mydb, 'select a.cropid,c.name_var_lndrce,a.zone_A,a.zone_B,a.zone_C,a.zone_D,a.zone_E,a.rainfall_optimal_max,a.rainfall_optimal_mean,a.rainfall_optimal_min,a.rainfall_absolute_max,a.rainfall_absolute_mean,a.rainfall_absolute_min,a.temperature_optimal_max,a.temperature_optimal_mean,a.temperature_optimal_min,a.temperature_absolute_max,a.temperature_absolute_mean,a.temperature_absolute_min,a.soil_depth_optimal_deep,a.soil_depth_optimal_medium,a.soil_depth_optimal_low,a.soil_depth_absolute_deep,a.soil_depth_absolute_medium,a.soil_depth_absolute_low,a.soil_ph_optimal_max,a.soil_ph_optimal_mean,a.soil_ph_optimal_min,a.soil_ph_absolute_max,a.soil_ph_absolute_mean,a.soil_ph_absolute_min,b.period_between_harvest_min,b.period_between_harvest_max from agro_agroecology a, agro_crop_season b , crop_taxonomy c where a.cropid=b.cropid and b.cropid=c.cropid and  a.temperature_absolute_min is not null and a.temperature_optimal_min is not null and a.temperature_optimal_max is not null and a.temperature_absolute_max is not null and a.rainfall_absolute_min is not null and a.rainfall_optimal_min is not null and a.rainfall_optimal_max is not null and a.rainfall_absolute_max is not null;') 


# Retrieving data from MySQL:
#   To retrieve data from the database we need to save a results set object.

# rs = dbSendQuery(mydb, "select * from gbif_taxon")

#I believe that the results of this query remain on the MySQL server, to access the results in R we need to use the fetch function.

ecology3 = fetch(rs, n=-1)

# names(ecology3)
# ecology3 <- ecology3[-2] 
  write.csv(ecology3, file = "MyData.csv")
# paste(data, collapse=", ")


# calculate the seasonal suitability for average seasonal temperature for n crops
 tecocrop = numeric()
 
for (i in 1:nrow(ecology3)){
  tmonsuit = numeric()  
    for (j in 1:12){
    x = utemp[j]/10
    tabs_min=ecology3[i,"temperature_absolute_min"] 
    tabs_min
    topt_min=ecology3[i,"temperature_optimal_min"] 
    topt_max=ecology3[i,"temperature_optimal_max"] 
    tabs_max=ecology3[i,"temperature_absolute_max"]
    if (x < tabs_min) {y = 0}
    if ((x >= tabs_min) & (x < topt_min)) {y = ((x - tabs_min)/(topt_min - tabs_min))}
    if ((x>= topt_min) & (x <topt_max))   {y=1}
    if ((x >= topt_max) & (x <tabs_max))   {y  = 1-( (x - topt_max)/(tabs_max - topt_max))} 
    if (x >= tabs_max) {y=0}
    tmonsuit= append(tmonsuit, as.numeric(y))  #CHAN test2
  }
  teco = cbind (tabs_min,topt_min,topt_max,tabs_max)
  tecocrop = rbind(tecocrop, teco)
  names(tmonsuit) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
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
    x <- get(paste("rainaggreg",i, sep=""))[j]
    rabs_min=ecology3[i,"rainfall_absolute_min"] 
    ropt_min=ecology3[i,"rainfall_optimal_min"] 
    ropt_max=ecology3[i,"rainfall_optimal_max"] 
    rabs_max=ecology3[i,"rainfall_absolute_max"]
    if (x < rabs_min) {y = 0}
    if ((x >= rabs_min) & (x < ropt_min)) {y = ((x - rabs_min)/(ropt_min - rabs_min))}
    if ((x >= ropt_min) & (x < ropt_max)) {y=1}
    if ((x >= ropt_max) & (x < rabs_max)) {y  = (1-( (x - ropt_max)/(rabs_max - ropt_max)))}
    if (x >= rabs_max) {y = 0}
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



# calculate total suitability 
for (j in 1:nrow(ecology3)){
  totalsuit = numeric()
  temptotcal = as.numeric(get(paste("tcropsuit",j, sep="")))
  raintotcal = as.numeric(get(paste("rcropsuit",j, sep="")))
  
  for (i in 1:12){
    totalsuit=append(totalsuit,(temptotcal[i]* raintotcal[i])) 
  }
  
  names(totalsuit) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
  assign(paste("totalsuit",j, sep="") , totalsuit) 
}

#control the quality
TCS=numeric()
for (i in 1:nrow(ecology3)){
  TCS = rbind(TCS,get(paste("totalsuit",i,sep=""))*100)
}

write.csv(cbind(CROP_ID = ecology3[,1],TCS), "")

