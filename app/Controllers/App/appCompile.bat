@echo off
set appPath=%1

cd %appPath%/android

gradlew.bat assemble

@REM npx react-native build-android --mode=release --no-packager