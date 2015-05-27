start = digits:[0-9]+ {
  return intval(join('', $digits));
}