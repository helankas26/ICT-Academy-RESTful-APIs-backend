<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expenditure extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'expenditures';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'expenseID';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expenseAmount' => 'decimal:10',
        'date' => 'datetime:Y-m-d'
    ];

    /**
     * Get the student that owns the branch.
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branchID', 'branchID');
    }

    /**
     * Get the staff who handles the expenditure.
     */
    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'handlerStaffID', 'staffID');
    }
}
