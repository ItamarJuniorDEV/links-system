# LinksSystem

> App web em Laravel 12 (Blade + DaisyUI) no estilo Linktree: cada usuário monta um perfil com vários links e expõe tudo numa página pública em `/usuario`.

![License](https://img.shields.io/badge/License-MIT-green)

## Sobre

Quase tudo que eu venho fazendo é API, então quis um projeto pra praticar o outro lado do Laravel: aplicação renderizada no servidor, com Blade, componentes e build de assets com Vite. A ideia de um "link na bio" (tipo Linktree) é pequena de propósito — o domínio cabe na cabeça — mas tem o suficiente pra exercitar o que me interessava: componentizar a UI sem repetir markup, manter um visual coeso com um tema próprio, e resolver autorização e reordenação sem gambiarra.

O usuário se cadastra, edita o perfil (foto, nome, descrição e um handle público), cria seus links e reordena na mão. A página pública fica em `linkssystem.com.br/handle` e é o que um visitante veria ao abrir o link da bio.

## Funcionalidades

- Cadastro, login e logout com autenticação por sessão e rate limit no login
- Verificação de e-mail por link, com reenvio
- Perfil editável: foto (com preview antes de salvar), nome, descrição e handle público
- CRUD de links
- Reordenação manual dos links (subir/descer)
- Página pública do perfil em `/{handle}`, com os links abrindo em nova aba
- Autorização por dono: ninguém edita, exclui ou reordena link de outro
- Validação por Form Request, incluindo regra própria pro formato do handle
- Feedback de sucesso e erro com flash messages
- Páginas de erro (404/403/500) no visual do app

## Stack

| Camada | Tecnologia |
|--------|------------|
| Linguagem | PHP 8.2 |
| Framework | Laravel 12 |
| Views | Blade + componentes |
| Estilo | Tailwind CSS 4 + DaisyUI 5 |
| Build | Vite |
| Banco | SQLite |
| Testes | PHPUnit 11 (SQLite in-memory) |

## Como rodar

Pré-requisitos: PHP 8.2+, Composer e Node 18+.

```bash
git clone https://github.com/ItamarJuniorDEV/links-system.git
cd links-system

composer install
npm install

cp .env.example .env
php artisan key:generate

touch database/database.sqlite
php artisan migrate
php artisan storage:link

npm run dev        # em um terminal (assets)
php artisan serve  # em outro
```

A app sobe em `http://localhost:8000`. Como não há landing, `/` redireciona pro login — crie uma conta em `/register` pra começar.

## Rotas

| Método | Rota | Acesso | Descrição |
|--------|------|--------|-----------|
| GET/POST | `/register`, `/login` | visitante | Cadastro e login |
| GET | `/logout` | autenticado | Encerra a sessão |
| GET/POST | `/email/verify` | autenticado | Verificação de e-mail (aviso e reenvio) |
| GET | `/` | verificado | Painel com o perfil e os links |
| GET/POST | `/links/create` | verificado | Cria link |
| GET/PUT | `/links/{link}/edit` | dono | Edita link |
| DELETE | `/links/{link}` | dono | Exclui link |
| PATCH | `/links/{link}/up`, `/down` | dono | Reordena |
| GET/PUT | `/profile` | verificado | Edita o próprio perfil |
| GET | `/{handle}` | público | Página pública do perfil |

As telas internas (painel, links, perfil) exigem e-mail verificado.

## Testes

```bash
php artisan test
```

São 37 testes rodando contra SQLite em memória (não tocam no banco de dev). Cobrem o cadastro/login/logout (com rate limit), a verificação de e-mail, a reordenação de links (swap de posição e casos de borda), a autorização dono × não-dono × visitante, o CRUD com validação e o `sort` automático, o perfil (handle único, normalização e upload de foto), a página pública, e a regra do handle isolada.

## Decisões técnicas

- **Autenticação por sessão, sem Sanctum.** É um app renderizado no servidor e aberto no navegador, então uso o guard padrão `web` (driver `session`, provider Eloquent sobre `App\Models\User`) — guard único, sem múltiplos guards. Sanctum ou Passport não entram porque não existe cliente externo trocando token.

- **Fluxo de auth escrito na mão.** Em vez de um starter kit (Breeze/Jetstream), login, cadastro e logout são controllers próprios apoiados em Form Requests: o `MakeLoginRequest` busca o usuário e chama `Auth::login`, o `RegisterRequest` cria e já autentica, o logout faz `Auth::logout` + `session()->invalidate()`. O cadastro dispara o evento `Registered` (que envia o e-mail de verificação) e as telas internas ficam atrás do middleware `verified`. Era justamente o que eu queria praticar aqui — o fluxo sem mágica de pacote.

- **Rate limit no login.** A rota de login usa um limiter próprio (`throttle:login`, definido no `AppServiceProvider`) com chave por e-mail + IP, 5 por minuto. Trava tentativa em massa sem prender quem erra a senha de vez em quando.

- **Hash e força de senha no lugar certo.** O `password` tem cast `hashed` no model, então o hash sai no `save()` sem `Hash::make` espalhado pelos controllers. A política de senha vem de `Password::defaults()` no `AppServiceProvider`: mínimo 8 em qualquer ambiente e, em produção, também maiúsculas/minúsculas e checagem contra vazamentos (`uncompromised`).

- **No cadastro, confirmo o e-mail (não a senha).** A regra `confirmed` está no campo `email` (espera `email_confirmation`). Como o login é por e-mail e o perfil é público, digitar errado tranca o acesso — confirmar o e-mail evita isso. A senha não tem campo de confirmação de propósito.

- **Autorização por Policy auto-descoberta.** A `LinkPolicy` é resolvida pela convenção de nome (no Laravel 12 não precisa registrar). O método `atualizar` é aplicado nas rotas via `can:atualizar,link`, e o `{link}` já chega resolvido por route model binding — então a checagem de dono roda antes de entrar no controller. Visitante nessas rotas é mandado pro login pelo middleware `auth`.

- **Mass assignment liberado com `Model::unguard()`.** Liguei `unguard()` global no `AppServiceProvider` em vez de manter `$fillable` em cada model. É uma troca consciente: como toda entrada passa por Form Request antes de chegar no Eloquent, a validação fica na borda e os models ficam sem cerimônia. Num projeto maior eu reavaliaria.

- **Reordenação por troca de `sort`.** Cada link tem um campo `sort`. Subir ou descer só troca o `sort` do link com o do vizinho (`Link::moveUp`/`moveDown`), sem reindexar a lista inteira. Nas pontas (primeiro/último) a operação é no-op.

- **Página pública como rota catch-all.** O perfil mora em `/{handle}`, que casa com qualquer caminho de um segmento. Por isso é a **última** rota do `web.php`: o health check `/up`, `/login`, `/profile` e as rotas de links resolvem antes, e o catch-all fica só com o que sobra. Handle inexistente cai no 404.

- **Handle validado por regra própria.** O username público passa pela regra `CheckHandler` (começa com letra; só minúsculas, números, ponto, hífen e underline) e é único por usuário. Antes de validar, o `prepareForValidation` tira um `@` inicial e baixa pra minúsculo.

- **Front-end configurado no CSS.** O Tailwind 4 é "CSS-first": não há `tailwind.config.js`, então fonte, tema e plugins ficam no próprio `app.css` (`@theme`, `@plugin "daisyui"` e o tema custom em `@plugin "daisyui/theme"` com `data-theme="linkssystem"`). A UI é montada com componentes Blade (`x-button`, `x-card`, `x-form`, `x-navbar`…), e o Vite com `@tailwindcss/vite` faz o build.

- **Tudo no banco, sem serviço externo.** Banco, sessão, cache e fila usam o driver de banco sobre SQLite. Pra rodar não precisa de Redis nem nada além do PHP e do arquivo SQLite.

- **Feedback com flash separado por tipo.** Sucesso e erro vão em chaves de sessão distintas (`success`/`error`); um componente `x-alert` no layout escolhe a cor e o ícone.

## Limitações conhecidas

Coisas que ficaram de fora por escopo, não por esquecimento:

- Sem reset de senha (fluxo de "esqueci a senha" não implementado).
- Os e-mails de verificação saem no driver `log` em desenvolvimento; envio real precisa configurar SMTP no `.env`.
- Em produção, as fotos iriam pra um disco público/S3 (já configurado em `filesystems.php`), não pro storage local.

## Licença

MIT
