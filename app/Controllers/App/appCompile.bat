@echo off
set appPath=%1

cd %appPath%

npx react-native build-android --mode=release --no-packager