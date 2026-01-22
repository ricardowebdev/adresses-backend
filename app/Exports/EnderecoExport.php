<?php 

namespace App\Exports;

use App\Repositories\EnderecoRepository;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EnderecoExport implements FromQuery, WithHeadings
{
    use Exportable;

    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function headings(): array
    {
        return [
            'id',
            'Cep',
            'UF',
            'Cidade',
            'Bairro',
            'Logradouro',
            'Numero',
            'Nome',
            'Telefone',
            'E-mail',
            'Registrado_em',
            'Removido_em'
        ];
    }

    public function query()
    {
        $repository = App::make(EnderecoRepository::class);
        return $repository->comRemovidos($this->filters); 
    }
}
