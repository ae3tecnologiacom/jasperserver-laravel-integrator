## JasperServer Laravel Integrator
Esta lib permite requisições às rotas rest2 do jasperserver a partir de um projeto em Laravel

### Requisitos
- PHP >= v7.1
- Laravel >= v5.8
- Composer >= v2

### Como configurar o projeto?

1) Adicione este repositório à lista de repositórios do composer em seu projeto laravel.
```json
{
  "repositories": [
    {
      "type": "git",
      "url": "https://gitlab.com/ae3-tecnologia-opensource/libs/jasperserver-laravel-integrator.git"
    }
  ]
}
```
2) Execute o comando a seguir para baixar esta lib ao vendor do seu projeto.
```
composer require ae3/jasperserver-laravel-integrator
```

3) Configure as variáveis abaixo no .env do seu projeto.
```
JASPER_SERVER_URL="<A URL de acesso ao seu JasperServer>"
JASPER_SERVER_USERNAME="<Username de acesso>"
JASPER_SERVER_PASSWORD="<Password de acesso>"
```

### Fazendo requisições ao servidor
Para efetuar as requisições ao servidor jasper, utilize o serviço **JasperServerRequestServiceContract**. Este serviço, além de conter 
o método **call(uri)** para efetuar a requisição, e os métodos auxiliares de configuração.

Segue abaixo exemplo de requisição para um relatório chamado **relatorio_teste**, contendo um parâmetro chamado **parametro_um**:

```php
$uri = '/relatorio_teste';

$report = $this->jasperServerRequestService
    ->addInputControl('parametro_um', 'valor_qualquer')
    ->setRequestTimeout(300)
    ->call($uri);

echo $report;
```

Por padrão os relatórios são retornados no formato **html**. Para especificar outro formato, basta utilizar o método
**setFormat** disponível no serviço:
```shell
$this->jasperServerRequestService
  ->setFormat('pdf')
  ...
```