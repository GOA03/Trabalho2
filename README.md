Sistema de Receitas

Desenvolvido por: Guilherme Opieko Auer

Descrição do Projeto
    O Sistema de Receitas é uma aplicação web desenvolvida em PHP que oferece uma plataforma robusta para o gerenciamento de receitas. Os usuários podem adicionar, visualizar, editar e excluir receitas de forma intuitiva e eficiente. O design e a arquitetura da aplicação seguem o padrão Model-View-Controller (MVC), garantindo uma separação clara da lógica de negócios, interface do usuário e interação com o banco de dados. A aplicação utiliza autenticação baseada em sessões para restringir o acesso a áreas sensíveis, garantindo que apenas usuários autorizados possam realizar ações específicas.

Particularidades
    Bugs conhecidos:
    Autenticação após Logout: Atualmente, há um bug identificado onde, após realizar o "logout", a sessão do usuário ainda permanece ativa. Para contornar isso temporariamente, é necessário eliminar a sessão manualmente através do DevTools do navegador.


Instalação:
    A instalação é simplificada e direta. Para garantir uma configuração adequada, siga os passos detalhados na Documentação de Configuração e Instalação que acompanha o projeto.

Contribuições
Como único responsável por este projeto, cuidei de todas as etapas. Isso inclui:

Backend em PHP: Implementação seguindo o padrão MVC.
Design: A interface foi cuidadosamente elaborada usando o framework Bootstrap.
Autenticação: Implementação de autenticação robusta usando sessões.
Tratamento de Erros: Implementação de tratamento de erros e validações para melhor experiência do usuário.
Documentação: Criação de documentação detalhada para facilitar a instalação e configuração.
