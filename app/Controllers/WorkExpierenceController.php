<?php


namespace KBS\Controllers;


use KBS\Entities\WorkExpierence;
use KBS\Request\Errors\Error;
use KBS\Request\Validator\Validator;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class WorkExpierenceController extends BaseController
{

    /**
     * Index page for work expierence
     *
     * @param \Psr\Http\Message\RequestInterface  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return mixed
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index(RequestInterface $request, ResponseInterface $response)
    {
        return $this->view->render($response, 'workexpierence/index.twig');
    }

    /**
     * Returns the edit function for
     *
     * @param \Psr\Http\Message\RequestInterface  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return mixed
     * @throws \ReflectionException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function create(RequestInterface $request, ResponseInterface $response)
    {
        $this->authenticate();

        $workExpierences = (new WorkExpierence())
            ->select()
            ->orderBy('begin_year', 'ASC')
            ->get();

        return $this->view->render($response, 'workexpierence/create.twig', [
            'workexpierences' => $workExpierences,
        ]);
    }

    /**
     * Stores the new work expierence.
     *
     * @param \Psr\Http\Message\RequestInterface  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return mixed
     * @throws \ReflectionException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function store(RequestInterface $request, ResponseInterface $response)
    {
        $this->authenticate();

        $validator = (new Validator($request))->setRules([
                                                             'title'      => 'required|max:255',
                                                             'employer'   => 'required',
                                                             'begin_year' => 'required',
                                                             'end_year'   => 'required',
                                                         ])
                                              ->validate();
        if ( ! $validator->validationPassed())
        {
            return $this->view->render($response, 'workexpierence/create.twig', [
                'errorTitle'       => Error::has('title') ? Error::get('title') : null,
                'errorDescription' => Error::has('errorDescription') ? Error::get('errorDescription') : null,
                'errorEmployer'    => Error::has('employer') ? Error::get('employer') : null,
                'errorBegindate'   => Error::has('begin_date') ? Error::get('begin_date') : null,
                'errorEnddate'     => Error::has('end_date') ? Error::get('end_date') : null,
            ]);
        }

        (new WorkExpierence())->insert([
                                           'name'        => $request->getParsedBody()['title'],
                                           'employee_id' => $request->getParsedBody()['employer'],
                                           'description' => $request->getParsedBody()['description'],
                                           'begin_year'  => $request->getParsedBody()['begin_year'],
                                           'end_year'    => $request->getParsedBody()['end_year'],
                                       ]);

        Error::clear();

        return $this->view->render($response, 'workexpirence/index.twig', [
            'success' => 'Succesvol uw werkervaring opgeslagen!',
        ]);
    }
}