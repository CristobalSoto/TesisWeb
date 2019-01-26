export class WebUtils {
  
  static sumArray(arreglo, len) {
    if (len === 0) {
      return 0
    } else {
      len--
      return arreglo[len] + this.sumArray(arreglo, len)
    }
  }
}  