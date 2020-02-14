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
write(paste("usercoords at: ", date(), args[1], args[2]), append=T)

# Creating a spatial point object from the given coordinates
coords = cbind(as.numeric(args[1]), as.numeric(args[2]))
coords = cbind(102.45386389999999, 3.2705262)
#sp = SpatialPoints(coords)
#data = 1
sp = SpatialPointsDataFrame(coords, data= as.data.frame(1))
crs(sp) = "+proj=longlat +datum=WGS84 +no_defs +ellps=WGS84 +towgs84=0,0,0"

# writing out the user coords points
# library(maptools)
writePointsShape(sp, "usercoord")
print(sp)

#source("./Rworshop/10_UCDF.R")
rm (list = ls())
