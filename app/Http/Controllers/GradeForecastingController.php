<?php

namespace App\Http\Controllers;

class GradeForecastingController
{
    public function forecasting()
    {
        $neededAverage = 4.65;
        $countOfCurrentGrades = 2;
        $sumOfCurrentGrades = 9;
        $maxGrade = 5;
        $minAllowedGrade = 3;

        $result = [];
        $forecastingRepeated = [];

        for ($forecastingCount = 1; $forecastingCount <= 100; $forecastingCount++) {
            $forecastingSumMin = ceil(
                $neededAverage * ($countOfCurrentGrades + $forecastingCount) - $sumOfCurrentGrades
            );

            $maxSum = $maxGrade * $forecastingCount;

            if ($forecastingSumMin > $maxSum) {
                continue;
            }

            $diff = $maxSum - $forecastingSumMin + 1;

            for ($d = 0; $d < $diff; $d++) {
                $sum = $forecastingSumMin + $d;
                $localResult = $this->split($sum, $forecastingCount);

//                $allowedLocalResult = [];
//                foreach ($localResult as $part) {
//                    $first = $part[0];
//                    $isGradeRepeated = true;
//                    foreach ($part as $num) {
//                        if ($num != $first) {
//                            $isGradeRepeated = false;
//                            break;
//                        }
//                    }
//
//                    if ($isGradeRepeated) {
//                        if (isset($forecastingRepeated[$first])) {
//                            #continue;
//                        }
//                        $forecastingRepeated[$first] = true;
//                    }
//
//                    $allowedLocalResult[] = $part;
//                }

                $result = array_merge($result, $localResult);
            }

            if (count($result) > 4) {
                break;
            }
        }

        dd($result);
    }

    public function split(int $sum, int $count): array
    {
        $allParts = [];
        $minGrade = 3;
        $maxGrade = 5;

        if ($count == 1) {
            if ($sum >= $minGrade && $sum <= $maxGrade) {
                return [[$sum]];
            }

            return [];
        }

        if ($sum / 5 == $count) {
            for ($i = 0; $i < $count; $i++) {
                $allParts[0][] = 5;
            }

            return $allParts;
        }

        $part = [];
        foreach (range(0, $count - 1) as $i) {
            $part[$i] = 1;
        }

        $part[0] = $sum - $count + 1;
        while (true) {
            $allParts[] = $part;
            if ($part[1] < $part[0] - 1) {
                $part[0] -= 1;
                $part[1] += 1;
            } else {
                $s = $part[0] - 1;

                $break = false;
                foreach (range(1, $count - 1) as $i) {
                    if ($part[$i] < $part[0] - 1) {
                        $break = true;
                        break;
                    }
                    $s += $part[$i];
                }

                if (!$break) {
                    break;
                }

                $part[$i] += 1;
                foreach (range(1, $i - 1) as $j) {
                    $part[$j] = $part[$i];
                    $s -= $part[$i];
                }
                $part[0] = $s;
            }
        }

        $allowedParts = [];

        foreach ($allParts as $part) {
            $isAllowed = true;
            foreach ($part as $num) {
                if ($num < $minGrade || $num > $maxGrade) {
                    $isAllowed = false;
                    break;
                }
            }

            if ($isAllowed) {
                $allowedParts[] = $part;
            }
        }

        return $allowedParts;
    }
}
# import numpy as np

# Total = 39
# Number_of_users = 8
# Average_score = 4
# Upper_boundary = 5

# probs = np.full(Number_of_users, 1.0/np.float64(Number_of_users), dtype=np.float64) # probabilities

# N = 100 # samples to test
# k = 0
# result = []
# while k < N:
#     q = np.random.multinomial(Total, probs)
#     t = np.where(q > Upper_boundary) # check for out-of boundaries
#     if np.any(t):
#         print("Rejected, out of boundaries") # reject, do another sample
#         continue
#     result.append(q)

#     k += 1

# print(result)

# import random
# out_list = []
# for i in range(1,7):
#     random_number = random.uniform(0,1)
#     if random_number < 0.75:
#         # Append uniform random number between 0 - 25 with probability .75
#         out_list.append(random.randint(5,5))
#     else:
#         #Append uniform random number between 0-75 with probability 0.25
#         out_list.append(random.randint(1,4))

# print(out_list)
# import statistics
# print(statistics.mean(out_list))
