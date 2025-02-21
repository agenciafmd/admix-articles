## F&MD - Articles

![Área Administrativa](https://github.com/agenciafmd/admix-articles/raw/master/docs/screenshot.png "Área Administrativa")

[![Downloads](https://img.shields.io/packagist/dt/agenciafmd/admix-articles.svg?style=flat-square)](https://packagist.org/packages/agenciafmd/admix-categories)
[![Licença](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

- Artigos no site sem dor de cabeça

## Instalação

```bash
composer require agenciafmd/admix-articles:v11.x-dev
```

Execute a migração

```bash
sail artisan migrate
```

Os seeds funcionarão diretamente do pacote. Caso precise de alguma customização, faça a publicação.

Não esqueça de corrigir os namespaces, paths das pastas e rodar o `composer dumpautoload` para que os arquivos sejam
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
    'sort' => 100,
    'author' => true,
    'call' => false,
    'short_description' => true,
    'video' => false,
    'published_at' => true,
    'image' => true,
    'gallery' => false,
];
```

Se for preciso, você pode customizar estas configurações

```bash
sail artisan vendor:publish --tag=admix-articles:configs
```

**caso tenha habilitado as categorias, é importante republicar os seeds**

Para as imagens, faça a mesclagem do `/vendor/agenciafmd/admix-articles/src/config/upload-configs.php` na sua aplicação

```
<?php

return [
    'article' => [
        'image' => [ //nome do campo
            'label' => 'imagem', //label do campo
            'multiple' => false, //se permite o upload multiplo
            'faker_dir' => false, #database_path('faker/article/image'),
            'sources' => [
                [
                    'conversion' => 'min-width-1366',
                    'media' => '(min-width: 1366px)',
                    'width' => 1024, // 16:9
                    'height' => 576,
                ],
                [
                    'conversion' => 'min-width-1280',
                    'media' => '(min-width: 1280px)',
                    'width' => 776,
                    'height' => 437,
                ],
            ],
        ],
    ],
    'articles-categories' => [
//        'image' => [ //nome do campo
//            'label' => 'imagem', //label do campo
//            'multiple' => false, //se permite o upload multiplo
//            'faker_dir' => false, #database_path('faker/articles-categories/image'),
//            'sources' => [
//                [
//                    'conversion' => 'min-width-1366',
//                    'media' => '(min-width: 1366px)',
//                    'width' => 1024, // 16:9
//                    'height' => 576,
//                ],
//                [
//                    'conversion' => 'min-width-1280',
//                    'media' => '(min-width: 1280px)',
//                    'width' => 776,
//                    'height' => 437,
//                ],
//            ],
//        ],
    ],
];
```

## Segurança

Caso encontre alguma falha de segurança, por favor, envie um email para irineu@fmd.ag ao invés de abrir uma issue

## Creditos

- [Irineu Junior](https://github.com/irineujunior)

## Licença

Licença MIT. [Clique aqui](LICENSE.md) para mais detalhes