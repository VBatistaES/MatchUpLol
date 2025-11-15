<template>
  <div class="p-6 max-w-2xl mx-auto min-h-screen text-white">
    <h1 class="text-2xl font-bold mb-4 text-white">Analisador de Matchup - League of Legends</h1>

    <form @submit.prevent="analyzeMatchup" class="space-y-3">
      <input v-model="champion" placeholder="Campeão" class="buttonChampion" />
      <input v-model="enemy" placeholder="Inimigo" class="buttonEnemy" />
      <select v-model="lane" class="buttonLane">
        <option value="">Selecione uma rota</option>
        <option value="TOP">TOP</option>
        <option value="MID">MID</option>
        <option value="JUNGLER">JUNGLER</option>
        <option value="ADC">ADC</option>
        <option value="SUPORTE">SUPORTE</option>
      </select>

      <button type="submit" class="buttonAnalisar">Analisar</button>
    </form>

    <div v-if="loading" class="mt-4 text-gray-400">Analisando matchup...</div>

    <div v-if="result" class="result">
      <h2 class="resultadoTexto">Resultado:</h2>
      <pre class="text-result">{{ result.analysis }}</pre>
    </div>
  </div>
</template>
<script setup>
import { ref } from 'vue';

const champion = ref('');
const enemy = ref('');
const lane = ref('');
const result = ref(null);
const loading = ref(false);

const analyzeMatchup = async () => {
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
