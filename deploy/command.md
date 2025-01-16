cd..
docker-compose -p store -f ./deploy/docker-compose.store.yml up -d

cd..
docker-compose -p server -f ./deploy/docker-compose.server.yml up -d


cd service
docker build -t customer-app -f Dockerfile.customer .
