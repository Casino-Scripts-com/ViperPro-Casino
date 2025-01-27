<template>
    <BaseLayout>
        <div class="w-full p-4">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="hidden md:block">
                    <img :src="`/assets/images/terms-conditions.png`" alt="" class="w-full">
                </div>
                <div class="">
                    <h4 class="text-2xl">Introdução</h4>
                    <br>
                    <p>1.1. Ao usar, visitar e/ou acessar qualquer parte do site {{ setting.software_name }} e/ou qualquer subdomínio, site ou aplicativo móvel que possuímos ou operamos (o “Site”) e/ou registrar uma conta no Site, você concorda em estar vinculado por estes Termos e Condições, nossa Política de Privacidade, nossa Política de Cookies e quaisquer outras regras aplicáveis aos nossos produtos de apostas ou jogos disponíveis no Site (juntos os 'Termos'), e considera-se que aceitou e entendeu todos os Termos.</p>
                    <br>
                    <h4 class="text-2xl">2.1. Requerimentos Legais</h4>
                    <br>
                    <p>2.1.1. Referência à “Conta” significa uma conta registrada por você no Site após aceitar e concordar com estes Termos. Ao registrar uma Conta, você declara que tem mais de 18 anos ou uma idade mínima legal superior, conforme estipulado na jurisdição de sua residência de acordo com as leis aplicáveis a você. É de sua exclusiva responsabilidade saber se os serviços disponíveis no Site são legais no país de sua residência. Pessoas menores de 18 anos não estão autorizadas a usar o Site e/ou quaisquer serviços nele disponíveis.</p>
                    <br>
                    <h4 class="text-2xl">3. Transações Financeiras e Saques</h4>
                    <br>
                    <p>3.1. A {{ setting.software_name }} reserva-se o direito de verificar a identidade do usuário antes de processar qualquer transação financeira. Isso pode incluir, mas não está limitado a, solicitar documentos de identificação e comprovantes de residência.</p>
                    <p>3.2. A {{ setting.software_name }} se reserva o direito de impor limites de saque a seu critério. Esses limites podem ser alterados a qualquer momento e sem aviso prévio.</p>
                    <p>3.3. A {{ setting.software_name }} não é responsável por quaisquer taxas ou encargos que possam ser cobrados pelo seu banco ou provedor de serviços financeiros.</p>
                    <p>3.4. As transações financeiras devem ser realizadas em nome do titular da conta registrada.</p>
                    <br>
                    <h4 class="text-2xl">4. Política de Privacidade</h4>
                    <br>
                    <p>4.1. Ao registrar uma conta no Site, você concorda com nossa Política de Privacidade. A Política de Privacidade é incorporada por referência a estes Termos e Condições.</p>
                    <br>
                    <h4 class="text-2xl">5. Direitos de Propriedade Intelectual</h4>
                    <br>
                    <p>5.1. O Site e todos os materiais nele contidos, incluindo, mas não se limitando a, logotipos, designs, textos, gráficos, fotos, vídeos, informações, software, música, som e outros arquivos, e sua seleção e arranjo (o "Conteúdo do Site"), são propriedade da {{ setting.software_name }} ou de seus licenciadores. Nenhum direito ou interesse no Conteúdo do Site é transferido para você.</p>
                    <br>
                    <h4 class="text-2xl">6. Rescisão</h4>
                    <br>
                    <p>6.1. A {{ setting.software_name }} reserva-se o direito de encerrar a sua conta a qualquer momento, a seu exclusivo critério, sem aviso prévio.</p>
                    <br>
                    <h4 class="text-2xl">7. Alterações aos Termos</h4>
                    <br>
                    <p>7.1. A {{ setting.software_name }} reserva-se o direito de alterar, modificar, adicionar ou remover partes destes Termos a qualquer momento e a seu exclusivo critério. Quando as alterações forem feitas, publicaremos as alterações revisadas no Site. Sua utilização contínua do Site após a publicação dessas alterações constituirá a sua aceitação dessas alterações.</p>

                    <h4 class="text-2xl">8. Limitação de Responsabilidade</h4>
                    <br>
                    <p>8.1. A {{ setting.software_name }} não será responsável por quaisquer danos diretos, indiretos, especiais, punitivos, incidentais, exemplares ou consequentes, ou quaisquer outros danos de qualquer tipo, incluindo, mas não se limitando a, perda de uso, perda de lucros ou perda de dados, seja em ação por contrato, delito (incluindo, mas não se limitando a, negligência) ou de outra forma, decorrentes de ou de qualquer forma relacionados com o uso ou incapacidade de usar o Site, os serviços, ou os materiais contidos em ou acessados através do Site.</p>
                    <br>
                    <h4 class="text-2xl">9. Lei Aplicável</h4>
                    <br>
                    <p>9.1. Estes Termos serão regidos e interpretados de acordo com as leis do país em que a {{ setting.software_name }} está registrada. Você concorda que qualquer ação legal ou equitativa que surja de ou esteja relacionada a estes Termos será decidida pelos tribunais do país em que a {{ setting.software_name }} está registrada, e você concorda e se submete à jurisdição pessoal e exclusiva desses tribunais.</p>
                    <br>
                    <h4 class="text-2xl">10. Uso de Hacks ou Bugs</h4>
                    <br>
                    <p>10.1. O uso de hacks, bugs ou qualquer outra forma de manipulação do sistema para obter uma vantagem injusta é estritamente proibido. A detecção de tais atividades levará ao bloqueio imediato da conta do usuário e à proibição de saques. A {{ setting.software_name }} se reserva o direito de tomar medidas legais contra qualquer usuário que esteja envolvido em tais atividades.</p>
                    <br>
                    <h4 class="text-2xl">11. Serviços de Terceiros</h4>
                    <br>
                    <p>11.1. O Site pode conter links para sites de terceiros que não são de propriedade ou controlados pela {{ setting.software_name }}. A {{ setting.software_name }} não tem controle sobre, e não assume nenhuma responsabilidade pelo conteúdo, políticas de privacidade ou práticas de qualquer site de terceiros. Ao usar o Site, você expressamente isenta a {{ setting.software_name }} de toda e qualquer responsabilidade decorrente do uso de qualquer site de terceiros.</p>
                    <br>
                    <h4 class="text-2xl">12. Indenização</h4>
                    <br>
                    <p>12.1. Você concorda em defender, indenizar e isentar a {{ setting.software_name }}, seus diretores, funcionários e agentes, de e contra quaisquer reivindicações, ações ou demandas, incluindo, sem limitação, custos legais e contábeis razoáveis, alegando ou resultantes de seu uso do Site e dos Serviços ou sua violação destes Termos.</p>
                    <br>
                    <h4 class="text-2xl">13. Reclamações de Direitos Autorais</h4>
                    <br>
                    <p>13.1. Se você acredita que seu trabalho foi copiado de uma maneira que constitui violação de direitos autorais, por favor, forneça as seguintes informações em sua reclamação: (a) identificação do trabalho protegido por direitos autorais que você alega ter sido violado; (b) identificação do material no Site que você alega estar infringindo; (c) seu endereço, número de telefone e endereço de e-mail; (d) uma declaração de que você acredita de boa fé que o uso disputado não é autorizado pelo proprietário dos direitos autorais, seu agente ou pela lei; (e) uma declaração feita por você, sob pena de perjúrio, de que as informações acima em sua reclamação são precisas e que você é o proprietário dos direitos autorais ou está autorizado a agir em nome do proprietário dos direitos autorais.</p>
                    <br>
                    <h4 class="text-2xl">14. Serviços de Atendimento ao Cliente</h4>
                    <br>
                    <p>14.1. Se você tiver alguma dúvida ou reclamação sobre o Site, os Serviços, ou estes Termos, você pode entrar em contato com o nosso serviço de atendimento ao cliente através do endereço de e-mail fornecido no Site.</p>
                    <br>
                    <h4 class="text-2xl">15. Disposições Gerais</h4>
                    <br>
                    <p>15.1. Se qualquer parte destes Termos for considerada inválida ou inexequível de acordo com a lei aplicável, a provisão inválida ou inexequível será considerada substituída por uma provisão válida e exequível que mais se aproxima da intenção da provisão original, e o restante dos Termos continuará em vigor.</p>
                    <p>15.2. Estes Termos, juntamente com a Política de Privacidade e quaisquer outros acordos legais publicados no Site, constituem o acordo integral entre você e a {{ setting.software_name }} em relação ao uso do Site e dos Serviços.</p>
                    <p>15.3. Qualquer falha da {{ setting.software_name }} em exercer ou impor qualquer direito ou disposição destes Termos não será considerada uma renúncia a tal direito ou disposição.</p>
                    <br>
                    <h4 class="text-2xl">16. Política de Jogo Responsável</h4>
                    <br>
                    <p>16.1. A {{ setting.software_name }} está comprometida em fornecer um ambiente de jogo seguro e responsável. Encorajamos todos os nossos jogadores a jogar de forma responsável e a reconhecer que o jogo é uma forma de entretenimento e não deve ser usado como meio de ganhar dinheiro.</p>
                    <p>16.2. Se você acredita que pode ter um problema de jogo, recomendamos que você procure ajuda profissional e que você se auto-exclua do nosso site.</p>
                    <br>
                    <h4 class="text-2xl">17. Política de Autoexclusão</h4>
                    <br>
                    <p>17.1. A {{ setting.software_name }} oferece uma política de autoexclusão para aqueles que acreditam que podem ter um problema de jogo. Se você optar por se autoexcluir, sua conta será fechada e você não poderá acessar o site por um período de tempo especificado.</p>
                    <br>
                    <h4 class="text-2xl">18. Política de Reembolso</h4>
                    <br>
                    <p>18.1. A {{ setting.software_name }} não oferece reembolsos, exceto em circunstâncias excepcionais. Qualquer pedido de reembolso será avaliado caso a caso.</p>
                    <br>
                    <h4 class="text-2xl">19. Política de Conta</h4>
                    <br>
                    <p>19.1 Cada usuário está estritamente proibido de registrar e manter mais de uma conta no Site. A violação desta política resultará no encerramento imediato de todas as contas associadas ao usuário, bem como em possíveis restrições de saques.</p>
                    <br>
                    <h4 class="text-2xl">20. Política de Verificação de Idade</h4>
                    <br>
                    <p>20.1. A {{ setting.software_name }} leva a verificação de idade muito a sério. Qualquer usuário suspeito de ser menor de idade será solicitado a fornecer prova de idade. A falha em fornecer tal prova resultará no fechamento da conta do usuário.</p>
                    <br>
                    <h4 class="text-2xl">21. Política de Jogo Justo</h4>
                    <br>
                    <p>21.1. A {{ setting.software_name }} está comprometida em fornecer um ambiente de jogo justo para todos os seus usuários. Qualquer usuário encontrado manipulando o sistema de qualquer maneira será banido permanentemente do site.</p>
                </div>
            </div>
        </div>

    </BaseLayout>
</template>


<script>

import BaseLayout from "@/Layouts/BaseLayout.vue";
import {useSettingStore} from "@/Stores/SettingStore.js";

export default {
    props: [],
    components: {BaseLayout},
    data() {
        return {
            isLoading: false,
            setting: null,
        }
    },
    setup(props) {


        return {};
    },
    computed: {

    },
    mounted() {

    },
    methods: {
        getSetting: function() {
            const _this = this;
            const settingStore = useSettingStore();
            const settingData = settingStore.setting;

            if(settingData) {
                _this.setting = settingData;
            }
        },
    },
    created() {
        this.getSetting();
    },
    watch: {

    },
};
</script>

<style scoped>

</style>
