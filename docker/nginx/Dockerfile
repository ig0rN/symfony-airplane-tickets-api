FROM nginx:stable-alpine

ADD site.conf /etc/nginx/conf.d/site.conf
RUN rm /etc/nginx/conf.d/default.conf

EXPOSE 80
EXPOSE 443
