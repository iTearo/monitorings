FROM openresty/openresty:1.17.8.2-4-alpine-fat

ARG NGINX_LUA_PROMETHEUS_VERSION=0.20181120

RUN opm get "knyar/nginx-lua-prometheus=${NGINX_LUA_PROMETHEUS_VERSION}"

COPY nginx.conf /usr/local/openresty/nginx/conf/nginx.conf
COPY metrics.conf /etc/nginx/metrics.conf

EXPOSE 80
EXPOSE 443
EXPOSE 9145
