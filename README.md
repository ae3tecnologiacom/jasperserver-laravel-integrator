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
      "url": "https://git.ae3tecnologia.com.br/AE3_TECNOLOGIA_OPENSOURCE/jasperserver-laravel-integrator"
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
Para efetuar as requisições ao servidor jasper, 
utilize o serviço [**JasperServerRequestServiceContract**](src/app/Services/Contracts/JasperServerRequestServiceContract.php). Este serviço, além de conter 
o método **call(uri)** para efetuar a requisição e os métodos auxiliares de configuração.

Segue abaixo exemplo de requisição para um relatório chamado **relatorio_teste**, contendo um parâmetro chamado **parametro_um**:

```php
$uri = '/relatorio_teste';

$report = $this->jasperServerRequestService
    ->addInputControl('parametro_um', 'valor_qualquer')
    ->setRequestTimeout(300)
    ->call($uri);
```

Por padrão os relatórios são retornados no formato **html**. Para especificar outro formato, basta utilizar o método
**setFormat** disponível no [serviço](src/app/Services/JasperServerRequestService.php) e o enum [ReportFormatEnum](src/app/Enums/ReportFormatEnum.php) com os formatos disponíveis:
```shell
$this->jasperServerRequestService
  ->setFormat(ReportFormatEnum::PDF)
  ...
```

#### Métodos inline() e download()
Caso queira forçar a renderização inline do relatório, 
basta utilizar a função ```inline()``` após o método ```call()```. Veja o exemplo abaixo:
```php
$uri = '/relatorio_teste';

$this->jasperServerRequestService
    ->addInputControl('parametro_um', 'valor_qualquer')
    ->setRequestTimeout(300)
    ->call($uri)
    ->inline();
```
Apenas arquivos que o navegador consegue renderizar serão 
exibidos. Caso contrário, o arquivo será baixado.

Caso queira forçar o download do arquivo, basta utilizar o método ```download('nome_do_arquivo')```, veja o exemplo abaixo:
```php
$uri = '/relatorio_teste';

$this->jasperServerRequestService
    ->addInputControl('parametro_um', 'valor_qualquer')
    ->setRequestTimeout(300)
    ->call($uri)
    ->download();
```
O nome do arquivo é opcional e, caso não seja informado, 
terá um valor randômico atribuído.

Caso você necessite obter o valor binário do relatório, pode utilizar
o método getReport(). Exemplo:
```php
$uri = '/relatorio_teste';

$report = $this->jasperServerRequestService
->addInputControl('parametro_um', 'valor_qualquer')
->setRequestTimeout(300)
->call($uri)
->getReport();
```