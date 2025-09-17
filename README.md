# ScholaPro

Modern, tiered SaaS Student Information System built on PHP 8.1 and PostgreSQL.

## Quick Start with Docker

```bash
# Clone the repository
git clone https://github.com/multifixconcepts/ScholaPro.git
cd ScholaPro

# Copy environment file
cp .env.example .env

# Start Docker containers
docker-compose up -d

# Access the application
http://localhost:8080
```

## Features by Subscription Tier

### Free Tier
- Core SIS functionality
- Basic gradebook
- Basic attendance tracking

### Bronze Tier
- All Free features
- Scheduling system
- Parent portal
- Basic reporting

### Silver Tier
- All Bronze features
- Student billing
- Discipline management
- Advanced reporting
- User import/export
- Basic API access

### Gold Tier
- All Silver features
- Custom report builder
- Advanced integrations
- Analytics dashboard
- White labeling
- Role management

## Development

Built with modern PHP practices:
- PHP 8.1+
- PostgreSQL
- Docker support
- PSR-12 coding standards
- Composer for dependency management
