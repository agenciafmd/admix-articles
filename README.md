## F&MD - Articles

![Área Administrativa](https://github.com/agenciafmd/admix-articles/raw/v11/docs/screenshot.png "Área Administrativa")

[![Downloads](https://img.shields.io/packagist/dt/agenciafmd/admix-articles.svg?style=flat-square)](https://packagist.org/packages/agenciafmd/admix-categories)
[![Licença](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

- Artigos

## Instalação

```bash
sail composer require agenciafmd/admix-articles:v11.x-dev
```

Execute a migração

```bash
sail artisan migrate
```

Os seeds funcionarão diretamente do pacote. Caso precise de alguma customização, faça a publicação.

Não esqueça de corrigir os namespaces, paths das pastas e rodar o `sail composer dumpautoload` para que os arquivos
sejam
encontrados

```bash
sail artisan vendor:publish --tag=admix-articles:seeders
```

## Configuração

Por padrão, as configurações do pacote são:

```php
<?php

return [
    'name' => 'Articles',
    'icon' => 'template',
    'sort' => 120,
    'category' => false,
    'author' => true,
    'call' => false,
    'short_description' => true,
    'video' => false,
    'published_at' => true,
    'image' => [
        'max' => 2048, // em kb
        'max_width' => 3840,
        'max_height' => 2160,
        'crop_config' => [
            // 'aspectRatio' => round(3840 / 2160, 2),
        ],
        'show_meta' => false,
    ],
    'gallery' => [
        //
    ],
];
```

Se for preciso, você pode customizar estas configurações

```bash
sail artisan vendor:publish --tag=admix-articles:configs
```

**caso tenha habilitado as categorias, é importante republicar os seeds**

## Segurança

Caso encontre alguma falha de segurança, por favor, envie um e-mail para irineu@fmd.ag ao invés de abrir uma issue

## Créditos

- [Irineu Junior](https://github.com/irineujunior)

## Licença

Licença MIT. [Clique aqui](LICENSE.md) para mais detalhes