document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('toggleBtn');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');

    // Verifica o estado salvo no localStorage (opcional)
    const isSidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    if (isSidebarCollapsed) {
        sidebar.classList.add('collapsed');
        // Não precisa ajustar mainContent aqui pois o CSS já cuida disso com '~'
    }

    toggleBtn.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');

        // Salva o estado no localStorage (opcional)
        if (sidebar.classList.contains('collapsed')) {
            localStorage.setItem('sidebarCollapsed', 'true');
        } else {
            localStorage.setItem('sidebarCollapsed', 'false');
        }

        // Lógica para mobile (se você quiser um comportamento diferente de expandir/recolher)
        // No CSS já temos uma media query que faz a sidebar iniciar colapsada em telas < 768px.
        // Se você quiser que o botão toggle expanda ela completamente no mobile,
        // você pode adicionar/remover uma classe específica como 'expanded-mobile'.
        if (window.innerWidth <= 768) {
            if (!sidebar.classList.contains('collapsed')) {
                sidebar.classList.add('expanded-mobile');
            } else {
                sidebar.classList.remove('expanded-mobile');
            }
        }
    });

    // Adiciona classe 'active' ao link clicado (exemplo simples)
    const menuLinks = document.querySelectorAll('.sidebar-menu li a');
    menuLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Remove 'active' de todos os links
            menuLinks.forEach(l => l.classList.remove('active'));
            // Adiciona 'active' ao link clicado
            this.classList.add('active');

            // Se a sidebar estiver colapsada e for clicado um item no mobile,
            // talvez você queira que ela se feche após o clique.
            if (window.innerWidth <= 768 && sidebar.classList.contains('expanded-mobile')) {
                // sidebar.classList.add('collapsed'); // Descomente se quiser fechar
                // sidebar.classList.remove('expanded-mobile'); // Descomente se quiser fechar
            }
        });
    });

    // Para garantir que o estado 'expanded-mobile' seja aplicado corretamente ao carregar
    // e ao redimensionar, se a sidebar não estiver 'collapsed' por padrão.
    function handleMobileExpansion() {
        if (window.innerWidth <= 768) {
            if (!sidebar.classList.contains('collapsed')) {
                // Se não estiver explicitamente colapsada, mas for mobile,
                // e você quiser que ela mostre o texto ao ser "não-colapsada" manualmente.
                // Esta parte pode ser complexa dependendo do comportamento desejado.
                // O CSS já colapsa por padrão no mobile. O JS expande com 'expanded-mobile'.
            }
        } else {
            // Remove a classe de expansão mobile se a tela for maior
            sidebar.classList.remove('expanded-mobile');
        }
    }

    window.addEventListener('resize', handleMobileExpansion);
    handleMobileExpansion(); // Chama ao carregar
});