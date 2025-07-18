# FlyHub

## Dicas

### Start Project

```shell

# Setup database tables
php artisan migrate

# Populate initial data
php artisan db:seed

# Npm packages
yarn install

# Build frontend
yarn dev

# Run tenant queue
php artisan tenants:run queue:work --tenants=zhf

# Run a custom app command
php artisan tenants:run sync --tenants=zhf

# Sync a specific resource
php artisan tenants:run sync --tenants=zhf --argument="type=receive" --argument="resource=categories"
```

## Problemas conhecidos

### Visualizar lista de portas reservadas no windows

```powershell
netsh int ip show excludedportrange protocol=tcp
```

### Liberar portas reservadas
## run as administrator
```powershell
net stop winnat
net start winnat
```
