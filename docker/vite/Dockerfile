FROM node:20-alpine

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apk add --no-cache git

# Enable Corepack for Yarn 4.x
RUN corepack enable

# Copy package files first for better caching
COPY package.json yarn.lock .yarnrc.yml ./
COPY .yarn ./.yarn

# Install dependencies
RUN yarn install

# Copy entrypoint script
COPY docker/vite/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expose Vite dev server port
EXPOSE 5173

# Use entrypoint to build then start dev server
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
