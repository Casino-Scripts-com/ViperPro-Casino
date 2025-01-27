<?php
namespace App\Models {
    use Illuminate\Database\Eloquent\Model;

    class SpinRuns extends Model
    {
        protected $table = 'ggds_spin_runs';

		protected $fillable = [
			'key',
			'nonce',
			'possibilities',
			'prize'
		];
    }
}

