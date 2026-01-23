<?php 

namespace App\Exports;

use App\Repositories\EnderecoRepository;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class EnderecoExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $filters;

    public function __construct(array $filters = [])
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

    public function collection(): Collection
    {
        $repository = App::make(EnderecoRepository::class);
        return $repository->excel($this->filters); 
    }
}
