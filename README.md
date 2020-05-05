## Cats

### Project Description

The project have URL's like whateverdomain.com/N, where N is integer between 1 and 1000000.

Each of these URLs outputs 3 different cat breeds from the cats.txt list in the following order: Cat1, Cat2, Cat3

Cat combinations are cached for 60 seconds, so if the combination Cat1, Cat2, Cat3 was displayed in the URL whateverdomain.com/N, then for 60 seconds that URL must return the same combination.

The project collects visitor statistics:

countAll - the sum of all page openings with all N values.
countN - the sum of openings for a specific N value.

The project writes a log file in JSON format for each opening from a new line:
{
"datetime": "yyyy-MM-dd HH: mm: ss",
"N": N,
"Cats": ["Cat1", "Cat2", "Cat3"],
"countAll": countAll,
"countN": countN
}
