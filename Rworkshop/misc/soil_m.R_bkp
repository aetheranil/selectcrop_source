library(rjson)
library(sp)
library(dplyr)
library(RMySQL)
library(jsonlite)

lon = 101.8776542
lat = 2.9372365
args <- commandArgs(trailingOnly = TRUE)
 lon = args[1]
 lat = args[2]

out <- NULL
  uri = paste("https://rest.soilgrids.org/query?lon=",lon,"&lat=",lat,"&attributes=CLYPPT,SLTPPT,SNDPPT,PHIHOX,BDRICM", sep="")
  #uri = paste("https://rest.soilgrids.org/query?lon=",101.54,"&lat=",3.849,"&attributes=CLYPPT,SLTPPT,SNDPPT,PHIHOX,BDRICM", sep="")
  #try( download.file(uri, "ret.txt", method="wininet"), silent = TRUE )
  
  #ret <- rjson::fromJSON(file="http://api.fantasy.nfl.com/v1/players/stats?statType=seasonStats&season=2010&week=1&format=json")
  #ret <- fromJSON(file='https://rest.soilgrids.org/query?lon=101.54&lat=3.849&attributes=CLYPPT,SLTPPT,SNDPPT,PHIHOX,BDRICM')
  #ret <- fromJSON(file='https://rest.soilgrids.org/query?lon=5.39&lat=51.57')
  
  # this one is working.
  #hadley_orgs <- fromJSON("https://rest.soilgrids.org/query?lon=5.39&lat=51.57")
  ret <- fromJSON(uri)
  
  
  
  if(!class(.Last.value)[1]=="try-error" & !length(ret$properties)==0){
    try(out[[1]] <- data.frame(ret$properties),silent = T)
    try(out[[1]]$lon <- y@coords[i,1],silent = T)
   #try(out[[1]]$lon <- 101.54,silent = T)
    try(out[[1]]$lat <- y@coords[i,2],silent = T)
    #try(out[[1]]$lat <- 3.849,silent = T)
    
    
  } else {    
    try(out[[1]] <- data.frame(lon=y@coords[i,1], lat=y@coords[i,2]),silent = T)
  }

## bind all elements together:
out <- plyr::rbind.fill(out)

# ecology3 <- read.csv("Agro_Agroecology2.csv")
# Connecting to MySQL:
#   Once the RMySQL library is installed create a database connection object.
mydb = dbConnect(MySQL(), user='root', password='yuna2UtR', dbname='cropbase_v_4_2', host='127.0.0.1')
# Listing Tables and Fields:
#   Now that a connection has been made we list the tables and fields in the database we connected to.
# Running Queries:
#   Queries can be run using the dbSendQuery function.


rs = dbSendQuery(mydb, 'select a.cropid,c.name_var_lndrce,
                  a.zone_A,a.zone_B,a.zone_C,a.zone_D,a.zone_E,
                  a.rainfall_optimal_max,a.rainfall_optimal_mean,
                  a.rainfall_optimal_min,a.rainfall_absolute_max,a.rainfall_absolute_mean,
                  a.rainfall_absolute_min,a.temperature_optimal_max,a.temperature_optimal_mean,
                  a.temperature_optimal_min,a.temperature_absolute_max,a.temperature_absolute_mean,
                  a.temperature_absolute_min,b.period_between_harvest_min,b.period_between_harvest_max ,

                  
                  a.soil_depth_optimal_deep,
                  a.soil_depth_optimal_medium,
                  a.soil_depth_optimal_low,

                  a.soil_depth_absolute_deep,
                  a.soil_depth_absolute_medium,
                  a.soil_depth_absolute_low,

                  a.soil_ph_optimal_max,
                  a.soil_ph_optimal_mean,
                  a.soil_ph_optimal_min,

                  a.soil_ph_absolute_max,
                  a.soil_ph_absolute_mean,
                  a.soil_ph_absolute_min,

                  a.soil_fertility_optimal_high,
                  a.soil_fertility_optimal_moderate, 
                  a.soil_fertility_optimal_low, 

                  a.soil_fertility_absolute_high, 
                  a.soil_fertility_absolute_moderate, 
                  a.soil_fertility_absolute_low                  
                 
                  from agro_agroecology a, agro_crop_season b , crop_taxonomy c 
                 
                 where a.cropid=b.cropid and b.cropid=c.cropid
  
                  and a.soil_depth_optimal_low  is not null
                  and a.soil_depth_optimal_medium  is not null
                  and a.soil_depth_optimal_deep  is not null

                  and a.soil_ph_optimal_max   is not null
                  and a.soil_ph_optimal_min  is not null

                  and a.soil_ph_absolute_max  is not null
                  and a.soil_ph_absolute_min  is not null

                  and a.soil_fertility_absolute_high   is not null
                  and a.soil_fertility_absolute_moderate  is not null
                  and a.soil_fertility_absolute_low       is not null

                  and a.soil_fertility_optimal_high is not null
                  and a.soil_fertility_optimal_moderate  is not null
                  and a.soil_fertility_optimal_low  is not null
                 ;')   






ecology3 = fetch(rs, n=-1)


# calcualte PH suitability

for (k in 1:nrow(ecology3)){
  phsuit = numeric()
  phsuitfun = function(x) {
    y=0
    phabs_min=ecology3[k,"soil_ph_absolute_min"] 
    phopt_min=ecology3[k,"soil_ph_optimal_min"] 
    phopt_max=ecology3[k,"soil_ph_optimal_max"] 
    phabs_max=ecology3[k,"soil_ph_absolute_max"]
    if (any(x > phabs_min) & any(x < phopt_min))  {y = round(((x - phabs_min)/(phopt_min - phabs_min))*100)}
    if (any(x > phopt_min) & any(x < phopt_max))  {y  = 100}
    if (any(x > phopt_max) & any(x < phabs_max))  {y  = round((1-( (x - phopt_max)/(phabs_max - phopt_max)))*100)}
    if (any(x < phabs_min) | any(x > phabs_max))  {y = 0}
    return(y)
  }  
  
  for (j in 1:7){
    
    phcalc <- out[1,12+j]/10
    
    phcalc <- lapply(phcalc, phsuitfun )
    
    phsuit= append(phsuit, phcalc)
    
  }
  names(phsuit) <- c("L1","L2","L3","L4","L5","L6","L7")
  assign(paste("phsuit",k, sep="") , phsuit)
}

# control the quality
# text=numeric()
# for (i in 1:nrow(cropdata)){
#   text = rbind(text,get(paste("phsuit",i,sep="")))
# }

# calcualte depth suitability
depthsuit = numeric() 
for (k in 1:nrow(ecology3)){

    depthsuitfun = function(x) {
    optz=10
    #t="t"    
    #if (x < 20) {
    #  if (ecology3[k,"soil_depth_optimal_low"] == 1) {
    #    optz == 100
    #  } 
    #}
    if ((x >=0) & (x< 50)) {
      if (ecology3[k,"soil_depth_optimal_low"] == 1) {
        optz = 100
      } else {
        optz = 10
      }
    }
    if ((x >= 50) & (x< 150)) {
      if (ecology3[k,"soil_depth_optimal_medium"] == 1) {
        optz = 100
      } else {
        optz = 10
      }
    }
    if (x >= 150) {
      if (ecology3[k,"soil_depth_optimal_deep"] == 1) {
        optz = 100
      } else {
        optz = 10
      }
    }
    # optz = ecology3[k,"Agr.Ecol.Opt.Soildp.Medium"]
    # absz = ecology3[k,"Agr.Ecol.Abs.Soildp.Mean"]

    # if (t == optz & t == absz) {y=100}
    # if (t != optz & t == absz) {y=50}
    # if (t == optz & t != absz) {y=80}
    # if (t != optz & t != absz) {y=10}
    
    return(optz)
  }  
 
  depthcalc <- lapply(out[1,"BDRICM.BDRICM_M"], depthsuitfun )
  depthsuit= append(depthsuit, depthcalc)
  
}
depthsuit <- as.numeric(depthsuit)
names(depthsuit) <- c(sprintf("Depthsuit",seq(1:k)))


# calculate the soil texture suitability for the selected crops
texturesuit = numeric() 
for (k in 1:nrow(ecology3)){

  # for (j in 1:7){
  #texturesuitfun = function(x) {
  #y=0
  texture = NULL
  
  #txtopt <- data[i,"Agr.Ecol.Opt.Soiltxt.Med"]
  #txtabs <- data[i,"Agr.Ecol.Abs.Soiltxt.Med"]
  # txtopt <- strsplit(as.character(ecology3[k,"Agr.Ecol.Opt.Soiltxt.Med"]), ";")
  # txtabs <- strsplit(as.character(ecology3[k,"Agr.Ecol.Abs.Soiltxt.Med"]), ";")
  
  #if (SLTPPT[1] <= 10) {t = "heavy"}
  if (((0 <= out[1,"SNDPPT.M.sl1"]) & (out[1,"SNDPPT.M.sl1"] <= 65)) &
      ((0 <= out[1,"SLTPPT.M.sl1"]) & (out[1,"SLTPPT.M.sl1"] <= 60)) &
      ((35 <= out[1,"CLYPPT.M.sl1"]) & (out[1,"CLYPPT.M.sl1"] <= 100))
  ) { texture = "heavy"}
  
  if (((0 <= out[1,"SNDPPT.M.sl1"]) & (out[1,"SNDPPT.M.sl1"] <= 52)) &
      ((28 <= out[1,"SLTPPT.M.sl1"]) & (out[1,"SLTPPT.M.sl1"] <= 100)) &
      ((0 <= out[1,"CLYPPT.M.sl1"]) & (out[1,"CLYPPT.M.sl1"] <= 27))
  ) { texture = "medium"}
  
  if (((70 <= out[1,"SNDPPT.M.sl1"]) & (out[1,"SNDPPT.M.sl1"] <= 100)) &
      ((0 <= out[1,"SLTPPT.M.sl1"]) & (out[1,"SLTPPT.M.sl1"] <= 30)) &
      ((0 <= out[1,"CLYPPT.M.sl1"]) & (out[1,"CLYPPT.M.sl1"] <= 13))
  ) { texture = "light"}
  
  #########
  #########
  #########
  ######### There is no initial condition for Y. so i made it Y=1
  y=10
  if (is.null(texture)){
    y = 10
  } else {

    if (texture =="heavy"){
      if (ecology3[k,"soil_fertility_optimal_high"] == 1) {
         y = 100
       }
      if (ecology3[k,"soil_fertility_absolute_high"] == 1) {
        y = 50
      }
    }
      
    if (texture =="medium"){
      if (ecology3[k,"soil_fertility_optimal_moderate"] == 1) {
        y = 100
      }
      if (ecology3[k,"soil_fertility_absolute_moderate"] == 1) {
        y = 50
      }
    }
    
    if (texture =="light"){
      if (ecology3[k,"soil_fertility_optimal_low"] == 1) {
        y = 100
      }
      if (ecology3[k,"soil_fertility_absolute_low"] == 1) {
        y = 50
      }
    }
 
  } 
    #return(y)
  #}  
  #texturecalc <- lapply(uBDRICM, texturesuitfun )
  texturesuit = append(texturesuit, y)
}
texturesuit <- as.numeric(texturesuit)
names(texturesuit) <- c(sprintf("texturesuit",seq(1:k)))


# calculate total suitability 
totalsoilsuit = numeric()
averagesoilsuit = numeric()

for (k in 1:nrow(ecology3)){
  
  #temptotcal = as.numeric(get(paste("tempsuit",k, sep="")))
  #raintotcal = as.numeric(get(paste("rainsuit",k, sep="")))
  phtotcal = as.numeric(get(paste("phsuit",k, sep="")))[1]
  depthtotcal = as.numeric(depthsuit[k])
  txturtotcal = as.numeric(texturesuit[k])
  #norainsuit = numeric()
  
  #for (i in 1:12){
    #totalsuit=append(totalsuit,(0.00000001*(temptotcal[i]* raintotcal[i] * phtotcal * depthtotcal * txturtotcal)))
    totalsoilsuit= append (totalsoilsuit,(phtotcal * depthtotcal * txturtotcal)/10000)
    
    #averagesuit=append(averagesuit,(mean(c(temptotcal[i], raintotcal[i] , phtotcal , depthtotcal , txturtotcal))))
    averagesoilsuit=append(averagesoilsuit, mean(c(phtotcal , depthtotcal , txturtotcal)))
    
    #norainsuit=append(norainsuit,(0.000001*(temptotcal[i]* phtotcal * depthtotcal * txturtotcal)))
    #norainsuit=append(norainsuit,(0.000001*(phtotcal * depthtotcal * txturtotcal)))
    
    #totalsuit=append(totalsuit,(0.01*(temptotcal[i]* raintotcal[i])))
  #}
  #names(totalsuit) <- data[1:nrow(data),1]
  #names(totalsuit) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
  #assign(paste("totalsoilsuit",k, sep="") , totalsoilsuit))
  #assign(paste("averagesoilsuit",k, sep="") , averagesoilsuit)
  #assign(paste("norainesoilsuit",k, sep="") , norainsoilsuit)
  
  #assign(paste("calc",k, sep=""), cbind(ph=rep(phtotcal,12) , depth=rep(depthtotcal,12), texture=rep(txturtotcal,12), totalsoilsuit = totalsoilsuit, avetotal = averagesoilsuit))
}

totalsoilsuit = cbind(totalsoilsuit, cropid = ecology3$cropid)
averagesoilsuit = cbind(averagesoilsuit, cropid = ecology3$cropid)

#control the quality
# TSsoil=data.frame()
# aveTSsoil=data.frame()
# 
# for (i in 1:nrow(ecology3)){
#   TSsoil = 
#     rbind(TSsoil,get(paste("totalsoilsuit",i,sep="")))
#   aveTSsoil = rbind(aveTSsoil,get(paste("averagesoilsuit",i,sep="")))
# }


# 
# write.csv(cbind(TS,crop), paste("TS",crop,".csv",sep=""))
# write.csv(cbind(aveTS,crop), paste("aveTS",crop,".csv",sep=""))
# write.csv(cbind(calcs,crop), paste("Calcs",crop,".csv",sep=""))
# write.csv(cbind(yearlycalc,cropdata[,c("lon","lat")]), paste("yearlycalc",crop,".csv",sep=""))
# 
# #rm(list = ls())

dbDisconnect(mydb)


options(scipen = 50)
# print(averagesoilsuit)
write.csv(cbind(CROP_ID = averagesoilsuit), "")
