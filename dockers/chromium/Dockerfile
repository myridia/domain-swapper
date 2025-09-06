# Pull the baseimage.
FROM jlesage/baseimage-gui:alpine-3.19-v4
USER root 
# Install xterm.
RUN add-pkg mesa-dri-gallium 
RUN add-pkg chromium 
RUN add-pkg nano 
RUN add-pkg curl

#RUN echo "10.5.0.2 www.app.local" >> /etc/hosts
COPY startapp.sh /startapp.sh

# Set the application name.
RUN set-cont-env APP_NAME "Chromium"


