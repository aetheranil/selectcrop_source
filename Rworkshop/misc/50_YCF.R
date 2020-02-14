# YCF.R
# Yield coordinate fetcher
# get reported yield coordinate for n selected crops
# ebrahim.jahanshiri@cffresearch.org


# check package requirements

list.of.packages <- c("rgdal", "maptools","RgoogleMaps")
new.packages <- list.of.packages[!(list.of.packages %in% installed.packages()[,"Package"])]
if(length(new.packages)) install.packages(new.packages)
lapply(list.of.packages, require, character.only = TRUE)

# GET THE SUBSETTED YIELD DATA WITH COORDINATES
yield <- read.csv("yield_subset.csv")

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
rm(list = ls())