# Builder modules
FROM node:24-bullseye AS builder
WORKDIR /app
COPY package.json package-lock.json* ./
# Разные версии Ноды на хосте | докере -  Cannot find module '../lightningcss.linux-x64-gnu.node'
RUN npm install --no-package-lock
COPY . .

# Runner Next.js 
FROM node:24-bullseye AS runner
WORKDIR /app
COPY --from=builder /app/node_modules ./node_modules
COPY --from=builder /app ./
CMD ["npm", "run", "dev"]
