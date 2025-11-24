export default class FaultForm {
    sortMachines(machines) {
        return machines.sort((a, b) => Number(a.number) - Number(b.number));
    }
}
