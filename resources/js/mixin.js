export default {
    data() {
        return {
            greeting: "",
            world: "World"
        };
    },
    computed: {
        hello: function() {
            return this.greeting + " " + this.world + "!";
        }
    }
};
