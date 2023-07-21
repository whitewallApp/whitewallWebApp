#!/bin/bash

appPath=$1
brandPath=$2

loadingimg=$3
headingimg=$4

#git clone https://github.com/yomas000/whitewallApp.git $appPath

cd $appPath

if test -f "$brandPath\\$headingimg"; then
       echo pwd
fi  

if test -f "$brandPath\\$loadingimg"; then
       echo pwd
fi 

#npm install
