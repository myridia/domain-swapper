# Pull the baseimage.
FROM jlesage/baseimage-gui:alpine-3.19-v4

# Install xterm.
RUN add-pkg mesa-dri-gallium 
RUN add-pkg chromium 
RUN add-pkg nginx
#RUN add-pkg openrc
RUN add-pkg curl

RUN adduser -D -g 'www' www
RUN mkdir /www
RUN chown -R www:www /var/lib/nginx
RUN chown -R www:www /www
RUN mv /etc/nginx/nginx.conf /etc/nginx/nginx.conf.orig
COPY nginx.conf /etc/nginx/
# Copy the start script.
COPY startapp.sh /startapp.sh

# Set the application name.
RUN set-cont-env APP_NAME "Chromium"


