<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model
{
    use HasFactory, SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'campaign_name',
        'version',
        'temporality',
        'partial_temporality',
        'start_date',
        'end_date',
        'url_commercial_proposal',
        'url_contract',
        'rebate',
        'payment_type',
        'notification_install',
        'client_id',
        'manager_cdmx_id',
        'admin_manager_id',
        'manager_internal_id',
        'manager_design_id',
        'form_id',
        'periodically',
        'campaign_type',
        'operation_date',
        'type',
	];
}