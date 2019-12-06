<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'sum', 'user_to_id', 'transaction_at', 'status'
    ];
    //Mutate string to Carbon
    protected $dates = [
        'transaction_at'
    ];

    public function scopeLastTransactions($query)
    {
        /*
         * select tr.user_id, tr.transaction_at, tr.user_to_id, tr.sum from transactions as tr
         * join transactions as tr2 on tr.user_id=tr2.user_id and tr2.transaction_at >= tr.transaction_at
         * group by tr.user_id, tr.transaction_at, tr.sum, tr.user_to_id
         * having count(*) <=1;
         * */

        $query->select(['tr1.user_id', 'tr1.transaction_at', 'tr1.user_to_id', 'tr1.sum'])
            ->from('transactions as tr1')
            ->join('transactions as tr2', function ($join) {
                $join->on('tr1.user_id', '=', 'tr2.user_id');
                $join->on('tr2.transaction_at', '>=', 'tr1.transaction_at');
            })
            ->groupBy(['tr1.user_id', 'tr1.transaction_at', 'tr1.user_to_id', 'tr1.sum'])
            ->havingRaw('count(*) <=1');
    }

    public static function getNextHourTransactions()
    {
        $fromTime = Carbon::now()->format('Y.m.d H:i');
        $toTime = Carbon::now()->addHour()->format('Y.m.d H:i');

        return Transaction::whereBetween('transaction_at', [$fromTime, $toTime])->get();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function user_to()
    {
        return $this->belongsTo(User::class, 'user_to_id');
    }
}
