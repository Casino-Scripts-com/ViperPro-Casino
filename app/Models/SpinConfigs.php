<?php
namespace App\Models {
    use Illuminate\Database\Eloquent\Model;

    class SpinConfigs extends Model
    {
        protected $appends = ['prizesArray'];
//        protected $casts = [
//            'prizesArray' => 'array',
//        ];

        protected $table = 'ggds_spin_config';

		protected $fillable = [
			'prizes'
		];

        /**
         * @return mixed
         */
        public function getPrizesArrayAttribute(): mixed
        {
            return json_decode($this->attributes['prizes'], true);
        }
    }
}
