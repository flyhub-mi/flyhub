<?php

namespace App\Http\Controllers\Tenant;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\DataTables\Tenant\SubscriberDataTable;
use App\Http\Controllers\BaseController;
use App\Repositories\Tenant\SubscriberRepository;

class SubscriberController extends BaseController
{
    /** @var  SubscriberRepository */
    private $subscriberRepository;

    /**
     * SubscriberController constructor.
     * @param SubscriberRepository $subscriberRepo
     */
    public function __construct(SubscriberRepository $subscriberRepo)
    {
        $this->subscriberRepository = $subscriberRepo;
    }

    /**
     * @param SubscriberDataTable $subscriberDataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(SubscriberDataTable $subscriberDataTable)
    {
        return $subscriberDataTable->render('tenant.subscribers.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $input = $request->input();

        $this->subscriberRepository->create($input);

        Flash::success('Subscriber criado.');

        return redirect(route('subscribers.index'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show($id)
    {
        $subscriber = $this->subscriberRepository->find($id);

        if (is_null($subscriber)) {
            Flash::error('Subscriber  não encontrada.');

            return redirect(route('subscribers.index'));
        }

        return view('tenant.subscribers.show')->with('subscriber', $subscriber);
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $subscriber = $this->subscriberRepository->find($id);

        if (is_null($subscriber)) {
            Flash::error('Subscriber  não encontrada.');

            return redirect(route('subscribers.index'));
        }

        $this->subscriberRepository->update($request->input(), $id);

        Flash::success('Subscriber atualizado.');

        return redirect(route('subscribers.index'));
    }
}
