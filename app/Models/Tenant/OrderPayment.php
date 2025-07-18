<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderPayment
 *
 * @OA\Schema (
 *      @OA\Xml(name="OrderPayment"),
 *      required={""},
 *      @OA\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="method",
 *          description="method",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="method_title",
 *          description="method_title",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="order_id",
 *          description="order_id",
 *          type="integer",
 *          format="int64"
 *      )
 * )
 * @property int $id
 * @property string $method
 * @property int $installments
 * @property string|null $transaction_id
 * @property int|null $order_id
 * @property string|null $total_paid
 * @property string|null $status
 * @property string|null $notes
 * @property string|null $issued_date
 * @property string|null $due_date
 * @property-read \App\Models\Order|null $order
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereInstallments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereIssuedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereTotalPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereTransactionId($value)
 * @mixin \Eloquent
 */
class OrderPayment extends Model
{
    /**
     * @var string
     */
    public $table = 'order_payment';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'method' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
