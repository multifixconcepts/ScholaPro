# ScholaPro Docker Setup

## Directory Structure
```
docker/
├── nginx/
│   └── conf.d/
│       └── default.conf
├── php/
│   ├── Dockerfile
│   └── php.ini
└── postgresql/
    └── init.sql
```

## Development Setup
1. Clone the repository
2. Copy `.env.example` to `.env`
3. Run `docker-compose up -d`
4. Access at `http://localhost:8080`

## Portainer Deployment
1. Stack name: scholapro
2. Repository URL: https://github.com/multifixconcepts/ScholaPro.git
3. Branch: main
4. Compose path: docker-compose.yml