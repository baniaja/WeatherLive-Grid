<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MachineLearningModel extends Model
{
    protected $table = 'machine_learning_models';

    protected $fillable = [
        'name',
        'type',
        'description',
        'version',
        'parameters',
        'accuracy',
        'precision_score',
        'recall',
        'f1_score',
        'rmse',
        'mae',
        'mape',
        'model_path',
        'status',
        'features',
        'targets',
        'trained_at',
        'last_evaluated_at',
    ];

    protected function casts(): array
    {
        return [
            'parameters' => 'array',
            'features' => 'array',
            'targets' => 'array',
            'trained_at' => 'datetime',
            'last_evaluated_at' => 'datetime',
        ];
    }
}

