<template>
    <div class="navbar">
        Ahoj {{userName}}
    </div>
</template>

<script>
    export default {
        data:()=>{
            return{
                userName: "xlacina5",
            };
        },
    };


</script>

<style>

.navbar{
    background:green;
    padding: 20px 0;
    color: white;
    font-weight:700;
}

</style>