<template>
  <div class="Topo1">
    <h1 class="Topo">Analisador de Matchup - League of Legends</h1>

    <form @submit.prevent="LoginPage" class="login">
      <input v-model="email" placeholder="Email" class="buttonEmail" />
      <input v-model="senha" placeholder="Senha" class="buttonSenha" />
      <button type="submit" class="buttonLogin">Logar</button>
    </form>

    <div v-if="loading" class="mt-4 text-gray-401">Analisando Login...</div>
  </div>
</template>
<script setup>
import { ref } from 'vue';

const email = ref('');
const senha = ref('');
const result = ref(null);
const loading = ref(false);

const LoginPage = async () => {
  loading.value = true;
  result.value = null;

  try {
    const response = await fetch('/api/matchup', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        champion: champion.value,
        enemy: enemy.value,
        lane: lane.value
      })
    });

    result.value = await response.json();
  } catch (error) {
    result.value = { analysis: 'Erro ao conectar com o servidor.' };
  } finally {
    loading.value = false;
  }
};
</script>
<style scoped>

input {
  border-radius: 8px;
}
</style>
