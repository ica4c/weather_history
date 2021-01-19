<?php

namespace App\Http\Procedures\V1\Weather;

use App\Http\Decorators\Weather\WeatherRecordingCollectionResponseDecorator;
use App\Http\Decorators\Weather\WeatherRecordingResponseDecorator;
use App\Http\Requests\V1\Weather\WeatherGetByDateRequest;
use App\Http\Requests\V1\Weather\WeatherHistoryRequest;
use App\Repositories\Temperature\TemperatureRecordingReadRepository;
use Carbon\Carbon;
use Sajya\Server\Procedure;

class WeatherQueryProcedure extends Procedure
{
    public static string $name = 'weather';

    /** @var \App\Repositories\Temperature\TemperatureRecordingReadRepository */
    protected $temperatureQueryRepo;

    /**
     * WeatherQueryProcedure constructor.
     *
     * @param \App\Repositories\Temperature\TemperatureRecordingReadRepository $temperatureQueryRepo
     */
    public function __construct(TemperatureRecordingReadRepository $temperatureQueryRepo)
    {
        $this->temperatureQueryRepo = $temperatureQueryRepo;
    }

    public function getByDate(WeatherGetByDateRequest $request) {
        $date = Carbon::parse($request->input('date'));
        $recording = $this->temperatureQueryRepo->queryForDate($date);
        $decorator = new WeatherRecordingResponseDecorator($recording);

        return $decorator->decorate();
    }

    public function getHistory(WeatherHistoryRequest $request) {
        $forDays = $request->input('lastDays');
        $endBy = now();
        $startFrom = now()->subDays($forDays);

        $recordings = $this->temperatureQueryRepo->queryBetweenDates($startFrom, $endBy);
        $decorator = new WeatherRecordingCollectionResponseDecorator($recordings);

        return $decorator->decorate();
    }
}
