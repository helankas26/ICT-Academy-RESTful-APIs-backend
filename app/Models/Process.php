<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Process extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'processes';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'processID';

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
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'updated_at' => 'timestamp:Y-m-d h:i A',
        'deleted_at' => 'timestamp:Y-m-d h:i A'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the process that owns the branch.
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branchID', 'branchID');
    }

    /**
     * Get the staff who handles the process.
     */
    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'handlerStaffID', 'staffID');
    }
}
