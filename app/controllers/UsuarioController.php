<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Validator;
use App\Core\Csrf;
use App\Repositories\UsuarioRepository;
use Throwable;

class UsuarioController
{
    private UsuarioRepository $repository;
    private Validator $validator;
    private View $view;

    public function __construct(UsuarioRepository $repository, Validator $validator, View $view)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->view = $view;
    }

    public function index(): void
    {
        $usuarios = $this->repository->all();
        $this->view->render('usuario/index', ['usuarios' => $usuarios]);
    }

    public function criar(): void
    {
        $this->view->render('usuario/criar');
    }

    public function armazenar(): void
    {
        if (!Csrf::validate($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Token CSRF inválido. Tente novamente.';
            redirect('/usuarios/criar');
        }

        $data = [
            'nome' => trim($_POST['nome'] ?? ''),
            'email' => trim($_POST['email'] ?? '')
        ];

        $this->validator->setData($data)
            ->required('nome', 'email')
            ->email('email')
            ->unique('email', 'usuarios');
        
        if (!$this->validator->passed()) {
            $_SESSION['errors'] = $this->validator->errors();
            $_SESSION['old'] = $data;
            redirect('/usuarios/criar');
        }

        try {
            $this->repository->create($data);
            $_SESSION['success'] = 'Usuário criado com sucesso!';
            redirect('/usuarios');
        } catch (Throwable $e) {
            $_SESSION['error'] = 'Ocorreu um erro ao salvar o usuário.';
            $_SESSION['old'] = $data;
            redirect('/usuarios/criar');
        }
    }

    public function editar(int $id): void
    {
        $usuario = $this->repository->find($id);
        if (!$usuario) {
            $_SESSION['error'] = 'Usuário não encontrado.';
            redirect('/usuarios');
        }
        $this->view->render('usuario/editar', ['usuario' => $usuario]);
    }

    public function atualizar(int $id): void
    {
        if (!Csrf::validate($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Token CSRF inválido. Tente novamente.';
            redirect("/usuarios/editar/{$id}");
        }

        $usuario = $this->repository->find($id);
        if (!$usuario) {
            $_SESSION['error'] = 'Usuário não encontrado.';
            redirect('/usuarios');
        }
        
        $data = [
            'nome' => trim($_POST['nome'] ?? ''),
            'email' => trim($_POST['email'] ?? '')
        ];

        $this->validator->setData($data)
            ->required('nome', 'email')
            ->email('email')
            ->unique('email', 'usuarios', $id);
        
        if (!$this->validator->passed()) {
            $_SESSION['errors'] = $this->validator->errors();
            $_SESSION['old'] = $data;
            redirect("/usuarios/editar/{$id}");
        }

        try {
            $this->repository->update($id, $data);
            $_SESSION['success'] = 'Usuário atualizado com sucesso!';
            redirect('/usuarios');
        } catch (Throwable $e) {
            $_SESSION['error'] = 'Ocorreu um erro ao atualizar o usuário.';
            $_SESSION['old'] = $data;
            redirect("/usuarios/editar/{$id}");
        }
    }

    public function deletar(int $id): void
    {
        if (!Csrf::validate($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Token CSRF inválido. Tente novamente.';
            redirect('/usuarios');
        }

        $this->repository->delete($id);
        $_SESSION['success'] = 'Usuário deletado com sucesso!';
        redirect('/usuarios');
    }
}
?>