to start php server

```
php -S localhost:3000
```

to use browsersync as proxy

```
yarn browser-sync 'http://localhost:3000' './' -w
```

use browsersync with static serve on stylesheet
```
yarnpkg browser-sync start --proxy 'http://localhost:3000/' --serveStatic './style.css' --files './style.css'
```

