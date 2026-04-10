<?

namespace App\Domains\Legal\Enums;

enum CaseStatus: string
{
    case OPEN = 'open';
    case IN_PROGRESS = 'in_progress';
    case CLOSED = 'closed';
}