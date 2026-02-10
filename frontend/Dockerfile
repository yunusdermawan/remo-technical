FROM node:20-alpine

WORKDIR /app

COPY package*.json ./

RUN ls -lah /app && cat /app/package.json

RUN npm install

COPY . .

EXPOSE 3000

CMD ["npm", "run", "dev", "--", "-H", "0.0.0.0"]