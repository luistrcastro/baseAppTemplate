# Dockerfile
FROM node:19-alpine

# create destination directory
RUN mkdir -p /client
WORKDIR /client

# update and install dependency
RUN apk update && apk upgrade
RUN apk add git

# RUN chown -R $user:$user .

USER $user

# copy the app, note .dockerignore
COPY package.json yarn.lock /client/
RUN yarn install

EXPOSE 3000

ENV NUXT_HOST=0.0.0.0
ENV NUXT_PORT=3000

CMD [ "yarn", "dev", "-o" ]