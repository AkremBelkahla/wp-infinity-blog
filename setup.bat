@echo off
echo Installation de l'environnement de developpement pour Infinity Blog Theme...

REM Verifier si Node.js est installe
where node >nul 2>nul
if %ERRORLEVEL% neq 0 (
    echo Node.js n'est pas installe. Veuillez installer Node.js (v14 ou superieur) avant de continuer.
    exit /b 1
)

REM Verifier la version de Node.js
for /f "tokens=1,2,3 delims=." %%a in ('node -v') do (
    set NODE_VERSION=%%a
)
set NODE_VERSION=%NODE_VERSION:~1%
if %NODE_VERSION% lss 14 (
    echo La version de Node.js est trop ancienne. Veuillez installer Node.js v14 ou superieur.
    exit /b 1
)

REM Installer les dependances
echo Installation des dependances npm...
call npm install

REM Creer les dossiers necessaires s'ils n'existent pas
if not exist css mkdir css
if not exist js mkdir js

REM Compiler les assets pour la production
echo Compilation des assets pour la production...
call npm run build

echo Installation terminee avec succes!
echo Pour developper, utilisez 'npm run watch'
echo Pour compiler pour la production, utilisez 'npm run build'
