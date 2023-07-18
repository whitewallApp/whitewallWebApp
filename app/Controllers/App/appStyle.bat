@echo off
set appPath=%1
set brandPath= %2

git clone https://github.com/yomas000/whitewallApp.git %appPath%

cd %appPath%

mkdir "%appPath%/Icons"

if exist %brandPath%/appHeading.jpeg (
    ROBOCOPY %brandPath% %appPath%/Icons/ appHeading.jpeg
)

if exist %brandPath%/appLoading.gif (
    ROBOCOPY %brandPath% %appPath%/Icons/ appLoading.gif
)

npm install

