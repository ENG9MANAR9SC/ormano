<?
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Enums\CaseStatus;

class CaseModel extends Model
{
    use HasFactory;

    protected $table = 'cases';

    protected $fillable = [
        'title',
        'description',
        //'client_id',
        'status',
        'start_date',
        'end_date',
        //'assigned_to',    
        'priority',       
    ];

    protected $casts = [
        //'status' => CaseStatus::class,
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Relations

}