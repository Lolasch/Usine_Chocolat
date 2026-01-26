<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConsommationsStock
 * 
 * @property int $id
 * @property int $stock_id
 * @property int|null $commande_id
 * @property int $quantite_utilisee
 * @property Carbon $date_consommation
 * @property string|null $qr_code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Commande|null $commande
 * @property Stock $stock
 *
 * @package App\Models
 */
class ConsommationsStock extends Model
{
	protected $table = 'consommations_stock';

	protected $casts = [
		'stock_id' => 'int',
		'commande_id' => 'int',
		'quantite_utilisee' => 'int',
		'date_consommation' => 'datetime'
	];

	protected $fillable = [
		'stock_id',
		'commande_id',
		'quantite_utilisee',
		'date_consommation',
		'qr_code'
	];

	public function commande()
	{
		return $this->belongsTo(Commande::class);
	}

	public function stock()
	{
		return $this->belongsTo(Stock::class);
	}
}
