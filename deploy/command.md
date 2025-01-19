./command run store/server/tool/all

docker-compose -p frontend -f docker-compose.front.yml up -d


docker build -t customer-app -f Dockerfile.customer .
docker build --no-cache -t customer-app -f Dockerfile.customer .
docker build -t shop-app -f Dockerfile.shop .


cd..
docker-compose -p store -f ./deploy/docker-compose.store.yml up -d

cd..
docker-compose -p server -f ./deploy/docker-compose.server.yml up -d


cd service
docker build -t customer-app -f Dockerfile.customer .

docker-compose -p tool -f docker-compose.tool.yml up -d