# Pull the baseimage.
FROM jlesage/baseimage-gui:alpine-3.19-v4
USER root 
# Install xterm.
RUN add-pkg mesa-dri-gallium 
RUN add-pkg chromium 
RUN add-pkg nano 
RUN add-pkg curl
RUN add-pkg nss-tools 
COPY minica.pem /root/
COPY pki /root/.pki
#RUN certutil -d sql:$HOME/.pki/nssdb -A -t "CT,C,C"  -n minica -i /root/minica.pem
#RUN ls /root/
COPY startapp.sh /startapp.sh

# Set the application name.
RUN set-cont-env APP_NAME "Chromium"


