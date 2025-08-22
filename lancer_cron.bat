@echo off
REM Aller dans le dossier de l'application
cd /d "C:\DISQUE E\Dev\Cakephp\vehicontrols2"

REM Lancer la commande CakePHP
bin\cake send_email_cron

REM Pause pour voir les résultats si lancé à la main
pause
