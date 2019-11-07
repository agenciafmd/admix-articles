## F&MD - Articles

![Área Administrativa](https://github.com/agenciafmd/admix-articles/raw/master/docs/screenshot.png "Área Administrativa")

[![Downloads](https://img.shields.io/packagist/dt/agenciafmd/admix-articles.svg?style=flat-square)](https://packagist.org/packages/agenciafmd/admix-categories)
[![Licença](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

- Artigos no site sem dor de cabeça

## Instalação

```bash
composer require agenciafmd/admix-articles:dev-master
```

## Configuração

TODO: Explicar a configuração da categoria

## Uso

TODO: Exemplificar o uso

## Customização

Copie o arquivo `/vendor/agenciafmd/admix-articles/src/config/admix-articles.php` para `config/admix-articles.php`

```php
<?php

return [
    'name' => 'Artigos',
    'icon' => 'icon fe-book',
    'sort' => 20,
    'default_sort' => [
        '-is_active',
        '-star',
        '-published_at',
        'name',
    ],
    'wysiwyg' => true,
    'category' => true,
    'call' => false,
    'short_description' => false,
    'video' => false,
    'published_at' => false,
    'download' => false,
];
```

Para as imagens, faça a mesclagem do `/vendor/agenciafmd/admix-articles/src/config/upload-configs.php` na sua aplicação

```
<?php

return [
    'article' => [
        'image' => [
            'name' => 'Imagem',
            'faker_dir' => false, #database_path('faker/articles/image'),
            'multiple' => false,
            'width' => 800,
            'height' => 600,
            'quality' => 95,
            'optimize' => true,
            'crop' => true,
        ],
        ...
        'avatar' => [
            'name' => 'Imagem',
            'faker_dir' => false, #database_path('faker/articles/avatar'),
            'multiple' => false,
            'width' => 200,
            'height' => 200,
            'quality' => 95,
            'optimize' => true,
            'crop' => true,
        ],
    ],
];
```

## Segurança

Caso encontre alguma falha de segurança, por favor, envie um email para irineu@fmd.ag ao invés de abrir uma issue

## Creditos

- [Irineu Junior](https://github.com/irineujunior)

## Licença

Licença MIT. [Clique aqui](LICENSE.md) para mais detalhes